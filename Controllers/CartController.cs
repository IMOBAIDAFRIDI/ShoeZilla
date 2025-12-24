using Microsoft.AspNetCore.Mvc;
using ShoeZilla.Data;
using ShoeZilla.Extensions;
using ShoeZilla.Models;

namespace ShoeZilla.Controllers
{
    public class CartController : Controller
    {
        private readonly ApplicationDbContext _context;

        public CartController(ApplicationDbContext context)
        {
            _context = context;
        }

        public IActionResult Index()
        {
            var cart = HttpContext.Session.Get<List<OrderItem>>("Cart") ?? new List<OrderItem>();
            return View(cart);
        }

        public IActionResult AddToCart(int id, int size)
        {
            var product = _context.Products.Find(id);
            if (product == null)
            {
                return NotFound();
            }

            var cart = HttpContext.Session.Get<List<OrderItem>>("Cart") ?? new List<OrderItem>();
            var existingItem = cart.FirstOrDefault(i => i.ProductId == id && i.Size == size);

            if (existingItem != null)
            {
                existingItem.Quantity++;
            }
            else
            {
                cart.Add(new OrderItem
                {
                    ProductId = product.Id,
                    Product = product, 
                    Quantity = 1,
                    Price = product.Price,
                    Size = size
                });
            }

            HttpContext.Session.Set("Cart", cart);
            return RedirectToAction("Index");
        }

        public IActionResult RemoveFromCart(int id, int size)
        {
            var cart = HttpContext.Session.Get<List<OrderItem>>("Cart") ?? new List<OrderItem>();
            var item = cart.FirstOrDefault(i => i.ProductId == id && i.Size == size);

            if (item != null)
            {
                cart.Remove(item);
                HttpContext.Session.Set("Cart", cart);
            }

            return RedirectToAction("Index");
        }
    }
}
