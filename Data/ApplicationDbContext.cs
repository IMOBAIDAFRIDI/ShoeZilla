
using Microsoft.EntityFrameworkCore;
using ShoeZilla.Models;

namespace ShoeZilla.Data
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
            : base(options)
        {
        }

        public DbSet<Product> Products { get; set; }
        public DbSet<Category> Categories { get; set; }
        public DbSet<User> Users { get; set; }
        public DbSet<Order> Orders { get; set; }
        public DbSet<OrderItem> OrderItems { get; set; }
        public DbSet<ContactMessage> ContactMessages { get; set; }
        public DbSet<Review> Reviews { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Seed Categories
            modelBuilder.Entity<Category>().HasData(
                new Category { Id = 1, Name = "Men" },
                new Category { Id = 2, Name = "Women" },
                new Category { Id = 3, Name = "Kids" },
                new Category { Id = 4, Name = "Joggers" }
            );

            // Seed Products
            var products = new List<Product>();
            int id = 1;

            // Men's Shoes (5 items repeated)
            var menTitles = new[] { "Classic Oxford", "Urban Boot", "Formal Derby", "City Loafer", "Weekend Sneaker", "Trail Hiker", "Business Brogue", "Summer Slip-on", "Winter Trekker", "Sport Trainer", "Canvas Classic", "Suede Chukka", "Leather Monk", "Chelsea Boot", "Driving Shoe", "Retro High-top", "Modern Runner", "Minimalist Sneaker", "Desert Boot", "Yacht Deck Shoe" };
            var menImages = new[] {
                "https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500&q=80", "https://images.unsplash.com/photo-1617689563472-c66428e83d17?w=500&q=80",
                "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=500&q=80", "https://images.unsplash.com/photo-1668069226492-508742b03147?w=500&q=80",
                "https://images.unsplash.com/photo-1614253429340-98120bd6d753?w=500&q=80"
            };
            foreach (var title in menTitles)
            {
                products.Add(new Product { Id = id++, Name = title, Description = $"Premium {title} designed for style and comfort.", Price = 79.99m + (id * 2), CategoryId = 1, ImageUrl = menImages[id % menImages.Length] });
            }

            // Women's Shoes (5 items repeated)
            var womenTitles = new[] { "Classic Pump", "Summer Sandal", "Ankle Boot", "Ballet Flat", "Running Trainer", "Platform Sneaker", "Leather Loafer", "Strappy Heel", "Winter Bootie", "Espadrille Wedge", "Canvas Slip-on", "Suede Moccasin", "Statement Heel", "Chelsea Boot", "Walking Shoe", "Fashion Sneaker", "Mule Slide", "Knee High Boot", "Peep Toe", "Mary Jane" };
            var womenImages = new[] {
                "https://images.unsplash.com/photo-1534653299134-96a171b61581?w=500&q=80", "https://images.unsplash.com/photo-1553808373-b2c5b7ddb117?w=500&q=80",
                "https://images.unsplash.com/photo-1539722833765-af2db79db72d?w=500&q=80", "https://images.unsplash.com/photo-1554062614-6da4fa67725a?w=500&q=80",
                "https://images.unsplash.com/photo-1605733513549-de9b150bd70d?w=500&q=80"
            };
            foreach (var title in womenTitles)
            {
                products.Add(new Product { Id = id++, Name = title, Description = $"Elegant {title} perfect for any occasion.", Price = 59.99m + (id * 1.5m), CategoryId = 2, ImageUrl = womenImages[id % womenImages.Length] });
            }

            // Kids Shoes (5 items repeated)
            var kidsTitles = new[] { "Velcro Sneaker", "Light-up Runner", "School Shoe", "Rain Boot", "Summer Sandal", "Winter Boot", "Sporty Trainer", "Canvas Slip-on", "Party Shoe", "Indoor Slipper", "Soccer Cleat", "High Top", "Character Shoe", "Toddler Walker", "Pre-school Runner", "Junior Hiker", "Beach Slide", "Warm Booties", "Dress Shoe", "Playground Sneaker" };
            var kidsImages = new[] {
                "https://images.unsplash.com/photo-1584564515943-b54cbb61836b?w=500&q=80", "https://images.unsplash.com/photo-1552912276-56ef47874741?w=500&q=80",
                "https://images.unsplash.com/photo-1507464098880-e367bc5d2c08?w=500&q=80", "https://images.unsplash.com/photo-1540479859555-17af45c78602?w=500&q=80",
                "https://images.unsplash.com/photo-1574946943172-4800feadfab7?w=500&q=80"
            };
            foreach (var title in kidsTitles)
            {
                products.Add(new Product { Id = id++, Name = title, Description = $"Durable {title} for active kids.", Price = 29.99m + (id * 1), CategoryId = 3, ImageUrl = kidsImages[id % kidsImages.Length] });
            }

            // Joggers (5 items repeated)
            var joggerTitles = new[] { "Pro Marathoner", "Sprint Spike", "Trail Blazer", "Cushion Cloud", "Speed Demon", "Endurance Pro", "Morning Jogger", "Track Star", "Lite Racer", "Impact Absorber", "Distance Runner", "Flex Sole", "Grip Master", "Aero Dynamic", "Urban Sprinter", "Night Runner", "Terrain Master", "Velocity Max", "Pace Setter", "Zoom Elite" };
            var joggerImages = new[] {
                "https://images.unsplash.com/photo-1597892657493-6847b9640bac?w=500&q=80", "https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500&q=80",
                "https://images.unsplash.com/photo-1602190420103-683df5093e86?w=500&q=80", "https://images.unsplash.com/photo-1581888748626-2a3f240a6f9f?w=500&q=80",
                "https://images.unsplash.com/photo-1709258228137-19a8c193be39?w=500&q=80"
            };
            foreach (var title in joggerTitles)
            {
                products.Add(new Product { Id = id++, Name = title, Description = $"High-performance {title} for serious runners.", Price = 89.99m + (id * 2.5m), CategoryId = 4, ImageUrl = joggerImages[id % joggerImages.Length] });
            }

            modelBuilder.Entity<Product>().HasData(products);
        }
    }
}
