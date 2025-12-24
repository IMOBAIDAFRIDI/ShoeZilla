using System.Diagnostics;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using ShoeZilla.Data;
using ShoeZilla.Models;

namespace ShoeZilla.Controllers;

public class HomeController : Controller
{
    private readonly ILogger<HomeController> _logger;
    private readonly ApplicationDbContext _context;

    public HomeController(ILogger<HomeController> logger, ApplicationDbContext context)
    {
        _logger = logger;
        _context = context;
    }

    public async Task<IActionResult> Index()
    {
        var featuredProducts = await _context.Products.Take(4).ToListAsync();
        return View(featuredProducts);
    }

    public async Task<IActionResult> Men(string sortOrder)
    {
        ViewData["CurrentSort"] = sortOrder;
        var productsQuery = _context.Products.Include(p => p.Category).Where(p => p.Category.Name == "Men");
        
        switch (sortOrder)
        {
            case "price_asc":
                productsQuery = productsQuery.OrderBy(p => p.Price);
                break;
            case "price_desc":
                productsQuery = productsQuery.OrderByDescending(p => p.Price);
                break;
        }

        var products = await productsQuery.ToListAsync();
        ViewData["CategoryName"] = "Men's Shoes";
        return View("Category", products);
    }

    public async Task<IActionResult> Women(string sortOrder)
    {
        ViewData["CurrentSort"] = sortOrder;
        var productsQuery = _context.Products.Include(p => p.Category).Where(p => p.Category.Name == "Women");

        switch (sortOrder)
        {
            case "price_asc":
                productsQuery = productsQuery.OrderBy(p => p.Price);
                break;
            case "price_desc":
                productsQuery = productsQuery.OrderByDescending(p => p.Price);
                break;
        }

        var products = await productsQuery.ToListAsync();
        ViewData["CategoryName"] = "Women's Shoes";
        return View("Category", products);
    }

    public async Task<IActionResult> Kids(string sortOrder)
    {
        ViewData["CurrentSort"] = sortOrder;
        var productsQuery = _context.Products.Include(p => p.Category).Where(p => p.Category.Name == "Kids");

        switch (sortOrder)
        {
            case "price_asc":
                productsQuery = productsQuery.OrderBy(p => p.Price);
                break;
            case "price_desc":
                productsQuery = productsQuery.OrderByDescending(p => p.Price);
                break;
        }

        var products = await productsQuery.ToListAsync();
        ViewData["CategoryName"] = "Kids' Shoes";
        return View("Category", products);
    }

    public async Task<IActionResult> Joggers(string sortOrder)
    {
        ViewData["CurrentSort"] = sortOrder;
        var productsQuery = _context.Products.Include(p => p.Category).Where(p => p.Category.Name == "Joggers");

        switch (sortOrder)
        {
            case "price_asc":
                productsQuery = productsQuery.OrderBy(p => p.Price);
                break;
            case "price_desc":
                productsQuery = productsQuery.OrderByDescending(p => p.Price);
                break;
        }

        var products = await productsQuery.ToListAsync();
        ViewData["CategoryName"] = "Joggers";
        return View("Category", products);
    }

    public async Task<IActionResult> Search(string query, string sortOrder)
    {
        if (string.IsNullOrWhiteSpace(query))
        {
            return RedirectToAction(nameof(Index));
        }

        ViewData["CurrentSort"] = sortOrder;
        var productsQuery = _context.Products
            .Include(p => p.Category)
            .Where(p => p.Name.Contains(query) || p.Description.Contains(query) || p.Category.Name.Contains(query));

        switch (sortOrder)
        {
            case "price_asc":
                productsQuery = productsQuery.OrderBy(p => p.Price);
                break;
            case "price_desc":
                productsQuery = productsQuery.OrderByDescending(p => p.Price);
                break;
        }

        var products = await productsQuery.ToListAsync();

        ViewData["CategoryName"] = $"Search Results for '{query}'";
        return View("Category", products);
    }

    public IActionResult Privacy()
    {
        return View();
    }

    public IActionResult OrderStatus(string trackingNumber)
    {
        if (string.IsNullOrEmpty(trackingNumber))
        {
            return View();
        }

        var order = _context.Orders
            .Include(o => o.OrderItems)
            .ThenInclude(oi => oi.Product)
            .FirstOrDefault(o => o.TrackingNumber == trackingNumber);

        if (order == null)
        {
            ViewBag.Error = "Order not found. Please check your tracking number.";
            return View();
        }

        return View(order);
    }

    public IActionResult ShippingReturns()
    {
        return View();
    }

    public IActionResult FAQ()
    {
        return View();
    }

    public IActionResult Contact()
    {
        return View();
    }

    [HttpPost]
    public async Task<IActionResult> Contact([Bind("Name,Email,Message")] ContactMessage contactMessage)
    {
        Console.WriteLine($"[DEBUG] Contact POST received. Name: {contactMessage.Name}, Email: {contactMessage.Email}, Msg: {contactMessage.Message}");
        
        if (ModelState.IsValid)
        {
            Console.WriteLine("[DEBUG] ModelState is VALID. Saving to DB...");
            _context.ContactMessages.Add(contactMessage);
            await _context.SaveChangesAsync();
            Console.WriteLine("[DEBUG] Saved to DB successfully.");
            TempData["Success"] = "Your message has been sent successfully!";
            return RedirectToAction(nameof(Contact));
        }
        else 
        {
            Console.WriteLine("[DEBUG] ModelState is INVALID.");
            foreach (var modelState in ModelState.Values) {
                foreach (var error in modelState.Errors) {
                    Console.WriteLine($"[DEBUG] Error: {error.ErrorMessage}");
                }
            }
        }
        return View(contactMessage);
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
        return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
}
