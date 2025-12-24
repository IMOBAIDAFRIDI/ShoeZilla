using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using ShoeZilla.Data;
using ShoeZilla.Models;
using System.Security.Claims;

namespace ShoeZilla.Controllers
{
    public class AccountController : Controller
    {
        private readonly ApplicationDbContext _context;

        public AccountController(ApplicationDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public IActionResult Login()
        {
            if (User.Identity!.IsAuthenticated)
            {
                return RedirectToAction("Index", "Home");
            }
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Login(string email, string password)
        {
            if (string.IsNullOrEmpty(email) || string.IsNullOrEmpty(password))
            {
                ViewBag.Error = "Please enter both email and password.";
                return View();
            }

            var user = await _context.Users.FirstOrDefaultAsync(u => u.Email == email && u.Password == password);

            if (user != null)
            {
                var claims = new List<Claim>
                {
                    new Claim(ClaimTypes.Name, user.FullName),
                    new Claim(ClaimTypes.Email, user.Email),
                    new Claim(ClaimTypes.Role, "User"),
                    new Claim("UserId", user.Id.ToString())
                };

                var claimsIdentity = new ClaimsIdentity(claims, "UserScheme");
                var authProperties = new AuthenticationProperties
                {
                    IsPersistent = true
                };

                await HttpContext.SignInAsync("UserScheme", new ClaimsPrincipal(claimsIdentity), authProperties);

                return RedirectToAction("Index", "Home");
            }

            ViewBag.Error = "Invalid Email or Password";
            return View();
        }

        [HttpGet]
        public IActionResult Register()
        {
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Register(User user)
        {
            if (ModelState.IsValid)
            {
                // Simple duplicate check
                if (await _context.Users.AnyAsync(u => u.Email == user.Email))
                {
                    ViewBag.Error = "Email already in use.";
                    return View(user);
                }

                user.Role = "User"; // Force role
                user.CreatedAt = DateTime.Now;
                
                _context.Users.Add(user);
                await _context.SaveChangesAsync();

                // Auto login after register
                var claims = new List<Claim>
                {
                    new Claim(ClaimTypes.Name, user.FullName),
                    new Claim(ClaimTypes.Email, user.Email),
                    new Claim(ClaimTypes.Role, "User"),
                    new Claim("UserId", user.Id.ToString())
                };

                var claimsIdentity = new ClaimsIdentity(claims, "UserScheme");
                await HttpContext.SignInAsync("UserScheme", new ClaimsPrincipal(claimsIdentity));

                return RedirectToAction("Index", "Home");
            }
            return View(user);
        }

        public async Task<IActionResult> Logout()
        {
            await HttpContext.SignOutAsync("UserScheme");
            return RedirectToAction("Login");
        }
    }
}
