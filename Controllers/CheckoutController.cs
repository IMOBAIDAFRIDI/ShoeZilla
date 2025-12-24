using Microsoft.AspNetCore.Mvc;
using ShoeZilla.Data;
using ShoeZilla.Extensions;
using ShoeZilla.Models;

namespace ShoeZilla.Controllers
{
    public class CheckoutController : Controller
    {
        private readonly ApplicationDbContext _context;

        public CheckoutController(ApplicationDbContext context)
        {
            _context = context;
        }

        public IActionResult Index()
        {
            var cart = HttpContext.Session.Get<List<OrderItem>>("Cart");
            if (cart == null || !cart.Any())
            {
                return RedirectToAction("Index", "Cart");
            }
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> PlaceOrder(string customerName, string customerEmail, string address, string paymentMethod)
        {
            var cart = HttpContext.Session.Get<List<OrderItem>>("Cart");
            if (cart == null || !cart.Any())
            {
                return RedirectToAction("Index", "Cart");
            }

            var order = new Order
            {
                CustomerName = customerName,
                CustomerEmail = customerEmail,
                ShippingAddress = address,
                PaymentMethod = paymentMethod,
                OrderDate = DateTime.Now,
                Status = "Pending",
                TrackingNumber = "TRK-" + Guid.NewGuid().ToString().Substring(0, 8).ToUpper(),
                TotalAmount = cart.Sum(i => i.Price * i.Quantity)
            };

            _context.Orders.Add(order);
            await _context.SaveChangesAsync();

            foreach (var item in cart)
            {
                item.OrderId = order.Id;
                item.Product = null; // Avoid re-saving product
                _context.OrderItems.Add(item);
            }
            await _context.SaveChangesAsync();

            HttpContext.Session.Remove("Cart");

            return RedirectToAction("Confirmation", new { id = order.Id });
        }

        public IActionResult Confirmation(int id)
        {
            var order = _context.Orders.Find(id);
            if (order == null) return NotFound();
            return View(order);
        }
    }
}
