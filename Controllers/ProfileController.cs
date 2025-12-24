using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using ShoeZilla.Data;
using System.Security.Claims;

namespace ShoeZilla.Controllers
{
    [Authorize(AuthenticationSchemes = "UserScheme")]
    public class ProfileController : Controller
    {
        private readonly ApplicationDbContext _context;

        public ProfileController(ApplicationDbContext context)
        {
            _context = context;
        }

        public async Task<IActionResult> Index()
        {
            var userIdClaim = User.FindFirst("UserId");
            if (userIdClaim == null)
            {
                return RedirectToAction("Login", "Account");
            }

            int userId = int.Parse(userIdClaim.Value);

            var user = await _context.Users.FindAsync(userId);
            
            // Fetch Orders separate or linked if relation exists. 
            // Since Order model had 'UserId', we can filter.
            // If explicit relation not set up in EF, we use simple Where.
            var orders = await _context.Orders
                .Include(o => o.OrderItems)
                .ThenInclude(oi => oi.Product)
                .Where(o => o.UserId == userId || o.CustomerEmail == user.Email) // Fallback to email if UserId wasn't saved in older logic
                .OrderByDescending(o => o.OrderDate)
                .ToListAsync();

            ViewBag.Orders = orders;

            return View(user);
        }
    }
}
