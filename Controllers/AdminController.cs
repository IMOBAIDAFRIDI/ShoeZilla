using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using ShoeZilla.Data;
using ShoeZilla.Models;
using System.Security.Claims;

namespace ShoeZilla.Controllers
{
    public class AdminController : Controller
    {
        private readonly ApplicationDbContext _context;

        public AdminController(ApplicationDbContext context)
        {
            _context = context;
        }

        [HttpGet]
        public IActionResult Login()
        {
            if (User.Identity!.IsAuthenticated)
            {
                return RedirectToAction("Index");
            }
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Login(string username, string password)
        {
            if (username == "admin" && password == "123")
            {
                var claims = new List<Claim>
                {
                    new Claim(ClaimTypes.Name, username),
                    new Claim(ClaimTypes.Role, "Admin")
                };

                var claimsIdentity = new ClaimsIdentity(claims, "AdminScheme");
                var authProperties = new AuthenticationProperties
                {
                    IsPersistent = true
                };

                await HttpContext.SignInAsync("AdminScheme", new ClaimsPrincipal(claimsIdentity), authProperties);

                return RedirectToAction("Index");
            }

            ViewBag.Error = "Invalid Username or Password";
            return View();
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult Index()
        {
            return View();
        }

        public async Task<IActionResult> Logout()
        {
            await HttpContext.SignOutAsync("AdminScheme");
            return RedirectToAction("Login");
        }

        // Manage Products
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult ManageProducts()
        {
            var products = _context.Products.Include(p => p.Category).ToList();
            return View(products);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult CreateProduct()
        {
            ViewBag.Categories = _context.Categories.ToList();
            return View();
        }

        [HttpPost]
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> CreateProduct(Product product)
        {
            if (ModelState.IsValid)
            {
                _context.Products.Add(product);
                await _context.SaveChangesAsync();
                return RedirectToAction("ManageProducts");
            }
            ViewBag.Categories = _context.Categories.ToList();
            return View(product);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> EditProduct(int id)
        {
            var product = await _context.Products.FindAsync(id);
            if (product == null) return NotFound();
            ViewBag.Categories = _context.Categories.ToList();
            return View(product);
        }

        [HttpPost]
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> EditProduct(Product product)
        {
             if (ModelState.IsValid)
            {
                _context.Products.Update(product);
                await _context.SaveChangesAsync();
                return RedirectToAction("ManageProducts");
            }
            ViewBag.Categories = _context.Categories.ToList();
            return View(product);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> DeleteProduct(int id)
        {
            var product = await _context.Products.FindAsync(id);
            if (product != null)
            {
                _context.Products.Remove(product);
                await _context.SaveChangesAsync();
            }
            return RedirectToAction("ManageProducts");
        }

        // Manage Orders
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult ManageOrders()
        {
            var orders = _context.Orders.Include(o => o.OrderItems).ThenInclude(oi => oi.Product).OrderByDescending(o => o.OrderDate).ToList();
            return View(orders);
        }

        [HttpPost]
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> UpdateOrderStatus(int id, string status)
        {
            var order = await _context.Orders.FindAsync(id);
            if (order != null)
            {
                order.Status = status;
                await _context.SaveChangesAsync();
            }
            return RedirectToAction("ManageOrders");
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> DeleteOrder(int id)
        {
            var order = await _context.Orders.FindAsync(id);
            if (order != null)
            {
                _context.Orders.Remove(order);
                await _context.SaveChangesAsync();
            }
            return RedirectToAction("ManageOrders");
        }

        // Manage Users
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult ManageUsers()
        {
            var users = _context.Users.ToList();
            return View(users);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult AddUser()
        {
            return View();
        }

        [HttpPost]
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> AddUser(User user)
        {
            if (ModelState.IsValid)
            {
                _context.Users.Add(user);
                await _context.SaveChangesAsync();
                return RedirectToAction("ManageUsers");
            }
            return View(user);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> EditUser(int id)
        {
            var user = await _context.Users.FindAsync(id);
            if (user == null) return NotFound();
            return View(user);
        }

        [HttpPost]
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> EditUser(User user)
        {
             if (ModelState.IsValid)
            {
                _context.Users.Update(user);
                await _context.SaveChangesAsync();
                return RedirectToAction("ManageUsers");
            }
            return View(user);
        }

        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public async Task<IActionResult> DeleteUser(int id)
        {
            var user = await _context.Users.FindAsync(id);
            if (user != null)
            {
                _context.Users.Remove(user);
                await _context.SaveChangesAsync();
            }
            return RedirectToAction("ManageUsers");
        }

        // Manage Contact Messages
        [Authorize(AuthenticationSchemes = "AdminScheme")]
        public IActionResult ManageMessages()
        {
            var messages = _context.ContactMessages.OrderByDescending(m => m.SubmittedAt).ToList();
            return View(messages);
        }
    }
}
