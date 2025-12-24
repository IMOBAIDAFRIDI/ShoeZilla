using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

#pragma warning disable CA1814 // Prefer jagged arrays over multidimensional

namespace ShoeZilla.Migrations
{
    /// <inheritdoc />
    public partial class InitialCreate : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "Categories",
                columns: table => new
                {
                    Id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    Name = table.Column<string>(type: "nvarchar(max)", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Categories", x => x.Id);
                });

            migrationBuilder.CreateTable(
                name: "Users",
                columns: table => new
                {
                    Id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    FullName = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    Email = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    Password = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    Role = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    CreatedAt = table.Column<DateTime>(type: "datetime2", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Users", x => x.Id);
                });

            migrationBuilder.CreateTable(
                name: "Products",
                columns: table => new
                {
                    Id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    Name = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    Description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    Price = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    ImageUrl = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    CategoryId = table.Column<int>(type: "int", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Products", x => x.Id);
                    table.ForeignKey(
                        name: "FK_Products_Categories_CategoryId",
                        column: x => x.CategoryId,
                        principalTable: "Categories",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "Orders",
                columns: table => new
                {
                    Id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    UserId = table.Column<int>(type: "int", nullable: true),
                    OrderDate = table.Column<DateTime>(type: "datetime2", nullable: false),
                    CustomerName = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    CustomerEmail = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    ShippingAddress = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    TotalAmount = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    Status = table.Column<string>(type: "nvarchar(max)", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Orders", x => x.Id);
                    table.ForeignKey(
                        name: "FK_Orders_Users_UserId",
                        column: x => x.UserId,
                        principalTable: "Users",
                        principalColumn: "Id");
                });

            migrationBuilder.CreateTable(
                name: "OrderItems",
                columns: table => new
                {
                    Id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    OrderId = table.Column<int>(type: "int", nullable: false),
                    ProductId = table.Column<int>(type: "int", nullable: false),
                    Quantity = table.Column<int>(type: "int", nullable: false),
                    Price = table.Column<decimal>(type: "decimal(18,2)", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_OrderItems", x => x.Id);
                    table.ForeignKey(
                        name: "FK_OrderItems_Orders_OrderId",
                        column: x => x.OrderId,
                        principalTable: "Orders",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_OrderItems_Products_ProductId",
                        column: x => x.ProductId,
                        principalTable: "Products",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.InsertData(
                table: "Categories",
                columns: new[] { "Id", "Name" },
                values: new object[,]
                {
                    { 1, "Men" },
                    { 2, "Women" },
                    { 3, "Kids" },
                    { 4, "Joggers" }
                });

            migrationBuilder.InsertData(
                table: "Products",
                columns: new[] { "Id", "CategoryId", "Description", "ImageUrl", "Name", "Price" },
                values: new object[,]
                {
                    { 1, 1, "Premium Classic Oxford designed for style and comfort.", "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=500&q=80", "Classic Oxford", 83.99m },
                    { 2, 1, "Premium Urban Boot designed for style and comfort.", "https://images.unsplash.com/photo-1668069226492-508742b03147?w=500&q=80", "Urban Boot", 85.99m },
                    { 3, 1, "Premium Formal Derby designed for style and comfort.", "https://images.unsplash.com/photo-1614253429340-98120bd6d753?w=500&q=80", "Formal Derby", 87.99m },
                    { 4, 1, "Premium City Loafer designed for style and comfort.", "https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500&q=80", "City Loafer", 89.99m },
                    { 5, 1, "Premium Weekend Sneaker designed for style and comfort.", "https://images.unsplash.com/photo-1617689563472-c66428e83d17?w=500&q=80", "Weekend Sneaker", 91.99m },
                    { 6, 1, "Premium Trail Hiker designed for style and comfort.", "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=500&q=80", "Trail Hiker", 93.99m },
                    { 7, 1, "Premium Business Brogue designed for style and comfort.", "https://images.unsplash.com/photo-1668069226492-508742b03147?w=500&q=80", "Business Brogue", 95.99m },
                    { 8, 1, "Premium Summer Slip-on designed for style and comfort.", "https://images.unsplash.com/photo-1614253429340-98120bd6d753?w=500&q=80", "Summer Slip-on", 97.99m },
                    { 9, 1, "Premium Winter Trekker designed for style and comfort.", "https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500&q=80", "Winter Trekker", 99.99m },
                    { 10, 1, "Premium Sport Trainer designed for style and comfort.", "https://images.unsplash.com/photo-1617689563472-c66428e83d17?w=500&q=80", "Sport Trainer", 101.99m },
                    { 11, 1, "Premium Canvas Classic designed for style and comfort.", "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=500&q=80", "Canvas Classic", 103.99m },
                    { 12, 1, "Premium Suede Chukka designed for style and comfort.", "https://images.unsplash.com/photo-1668069226492-508742b03147?w=500&q=80", "Suede Chukka", 105.99m },
                    { 13, 1, "Premium Leather Monk designed for style and comfort.", "https://images.unsplash.com/photo-1614253429340-98120bd6d753?w=500&q=80", "Leather Monk", 107.99m },
                    { 14, 1, "Premium Chelsea Boot designed for style and comfort.", "https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500&q=80", "Chelsea Boot", 109.99m },
                    { 15, 1, "Premium Driving Shoe designed for style and comfort.", "https://images.unsplash.com/photo-1617689563472-c66428e83d17?w=500&q=80", "Driving Shoe", 111.99m },
                    { 16, 1, "Premium Retro High-top designed for style and comfort.", "https://images.unsplash.com/photo-1605733160314-4fc7dac4bb16?w=500&q=80", "Retro High-top", 113.99m },
                    { 17, 1, "Premium Modern Runner designed for style and comfort.", "https://images.unsplash.com/photo-1668069226492-508742b03147?w=500&q=80", "Modern Runner", 115.99m },
                    { 18, 1, "Premium Minimalist Sneaker designed for style and comfort.", "https://images.unsplash.com/photo-1614253429340-98120bd6d753?w=500&q=80", "Minimalist Sneaker", 117.99m },
                    { 19, 1, "Premium Desert Boot designed for style and comfort.", "https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=500&q=80", "Desert Boot", 119.99m },
                    { 20, 1, "Premium Yacht Deck Shoe designed for style and comfort.", "https://images.unsplash.com/photo-1617689563472-c66428e83d17?w=500&q=80", "Yacht Deck Shoe", 121.99m },
                    { 21, 2, "Elegant Classic Pump perfect for any occasion.", "https://images.unsplash.com/photo-1539722833765-af2db79db72d?w=500&q=80", "Classic Pump", 92.99m },
                    { 22, 2, "Elegant Summer Sandal perfect for any occasion.", "https://images.unsplash.com/photo-1554062614-6da4fa67725a?w=500&q=80", "Summer Sandal", 94.49m },
                    { 23, 2, "Elegant Ankle Boot perfect for any occasion.", "https://images.unsplash.com/photo-1605733513549-de9b150bd70d?w=500&q=80", "Ankle Boot", 95.99m },
                    { 24, 2, "Elegant Ballet Flat perfect for any occasion.", "https://images.unsplash.com/photo-1534653299134-96a171b61581?w=500&q=80", "Ballet Flat", 97.49m },
                    { 25, 2, "Elegant Running Trainer perfect for any occasion.", "https://images.unsplash.com/photo-1553808373-b2c5b7ddb117?w=500&q=80", "Running Trainer", 98.99m },
                    { 26, 2, "Elegant Platform Sneaker perfect for any occasion.", "https://images.unsplash.com/photo-1539722833765-af2db79db72d?w=500&q=80", "Platform Sneaker", 100.49m },
                    { 27, 2, "Elegant Leather Loafer perfect for any occasion.", "https://images.unsplash.com/photo-1554062614-6da4fa67725a?w=500&q=80", "Leather Loafer", 101.99m },
                    { 28, 2, "Elegant Strappy Heel perfect for any occasion.", "https://images.unsplash.com/photo-1605733513549-de9b150bd70d?w=500&q=80", "Strappy Heel", 103.49m },
                    { 29, 2, "Elegant Winter Bootie perfect for any occasion.", "https://images.unsplash.com/photo-1534653299134-96a171b61581?w=500&q=80", "Winter Bootie", 104.99m },
                    { 30, 2, "Elegant Espadrille Wedge perfect for any occasion.", "https://images.unsplash.com/photo-1553808373-b2c5b7ddb117?w=500&q=80", "Espadrille Wedge", 106.49m },
                    { 31, 2, "Elegant Canvas Slip-on perfect for any occasion.", "https://images.unsplash.com/photo-1539722833765-af2db79db72d?w=500&q=80", "Canvas Slip-on", 107.99m },
                    { 32, 2, "Elegant Suede Moccasin perfect for any occasion.", "https://images.unsplash.com/photo-1554062614-6da4fa67725a?w=500&q=80", "Suede Moccasin", 109.49m },
                    { 33, 2, "Elegant Statement Heel perfect for any occasion.", "https://images.unsplash.com/photo-1605733513549-de9b150bd70d?w=500&q=80", "Statement Heel", 110.99m },
                    { 34, 2, "Elegant Chelsea Boot perfect for any occasion.", "https://images.unsplash.com/photo-1534653299134-96a171b61581?w=500&q=80", "Chelsea Boot", 112.49m },
                    { 35, 2, "Elegant Walking Shoe perfect for any occasion.", "https://images.unsplash.com/photo-1553808373-b2c5b7ddb117?w=500&q=80", "Walking Shoe", 113.99m },
                    { 36, 2, "Elegant Fashion Sneaker perfect for any occasion.", "https://images.unsplash.com/photo-1539722833765-af2db79db72d?w=500&q=80", "Fashion Sneaker", 115.49m },
                    { 37, 2, "Elegant Mule Slide perfect for any occasion.", "https://images.unsplash.com/photo-1554062614-6da4fa67725a?w=500&q=80", "Mule Slide", 116.99m },
                    { 38, 2, "Elegant Knee High Boot perfect for any occasion.", "https://images.unsplash.com/photo-1605733513549-de9b150bd70d?w=500&q=80", "Knee High Boot", 118.49m },
                    { 39, 2, "Elegant Peep Toe perfect for any occasion.", "https://images.unsplash.com/photo-1534653299134-96a171b61581?w=500&q=80", "Peep Toe", 119.99m },
                    { 40, 2, "Elegant Mary Jane perfect for any occasion.", "https://images.unsplash.com/photo-1553808373-b2c5b7ddb117?w=500&q=80", "Mary Jane", 121.49m },
                    { 41, 3, "Durable Velcro Sneaker for active kids.", "https://images.unsplash.com/photo-1507464098880-e367bc5d2c08?w=500&q=80", "Velcro Sneaker", 71.99m },
                    { 42, 3, "Durable Light-up Runner for active kids.", "https://images.unsplash.com/photo-1540479859555-17af45c78602?w=500&q=80", "Light-up Runner", 72.99m },
                    { 43, 3, "Durable School Shoe for active kids.", "https://images.unsplash.com/photo-1574946943172-4800feadfab7?w=500&q=80", "School Shoe", 73.99m },
                    { 44, 3, "Durable Rain Boot for active kids.", "https://images.unsplash.com/photo-1584564515943-b54cbb61836b?w=500&q=80", "Rain Boot", 74.99m },
                    { 45, 3, "Durable Summer Sandal for active kids.", "https://images.unsplash.com/photo-1552912276-56ef47874741?w=500&q=80", "Summer Sandal", 75.99m },
                    { 46, 3, "Durable Winter Boot for active kids.", "https://images.unsplash.com/photo-1507464098880-e367bc5d2c08?w=500&q=80", "Winter Boot", 76.99m },
                    { 47, 3, "Durable Sporty Trainer for active kids.", "https://images.unsplash.com/photo-1540479859555-17af45c78602?w=500&q=80", "Sporty Trainer", 77.99m },
                    { 48, 3, "Durable Canvas Slip-on for active kids.", "https://images.unsplash.com/photo-1574946943172-4800feadfab7?w=500&q=80", "Canvas Slip-on", 78.99m },
                    { 49, 3, "Durable Party Shoe for active kids.", "https://images.unsplash.com/photo-1584564515943-b54cbb61836b?w=500&q=80", "Party Shoe", 79.99m },
                    { 50, 3, "Durable Indoor Slipper for active kids.", "https://images.unsplash.com/photo-1552912276-56ef47874741?w=500&q=80", "Indoor Slipper", 80.99m },
                    { 51, 3, "Durable Soccer Cleat for active kids.", "https://images.unsplash.com/photo-1507464098880-e367bc5d2c08?w=500&q=80", "Soccer Cleat", 81.99m },
                    { 52, 3, "Durable High Top for active kids.", "https://images.unsplash.com/photo-1540479859555-17af45c78602?w=500&q=80", "High Top", 82.99m },
                    { 53, 3, "Durable Character Shoe for active kids.", "https://images.unsplash.com/photo-1574946943172-4800feadfab7?w=500&q=80", "Character Shoe", 83.99m },
                    { 54, 3, "Durable Toddler Walker for active kids.", "https://images.unsplash.com/photo-1584564515943-b54cbb61836b?w=500&q=80", "Toddler Walker", 84.99m },
                    { 55, 3, "Durable Pre-school Runner for active kids.", "https://images.unsplash.com/photo-1552912276-56ef47874741?w=500&q=80", "Pre-school Runner", 85.99m },
                    { 56, 3, "Durable Junior Hiker for active kids.", "https://images.unsplash.com/photo-1507464098880-e367bc5d2c08?w=500&q=80", "Junior Hiker", 86.99m },
                    { 57, 3, "Durable Beach Slide for active kids.", "https://images.unsplash.com/photo-1540479859555-17af45c78602?w=500&q=80", "Beach Slide", 87.99m },
                    { 58, 3, "Durable Warm Booties for active kids.", "https://images.unsplash.com/photo-1574946943172-4800feadfab7?w=500&q=80", "Warm Booties", 88.99m },
                    { 59, 3, "Durable Dress Shoe for active kids.", "https://images.unsplash.com/photo-1584564515943-b54cbb61836b?w=500&q=80", "Dress Shoe", 89.99m },
                    { 60, 3, "Durable Playground Sneaker for active kids.", "https://images.unsplash.com/photo-1552912276-56ef47874741?w=500&q=80", "Playground Sneaker", 90.99m },
                    { 61, 4, "High-performance Pro Marathoner for serious runners.", "https://images.unsplash.com/photo-1602190420103-683df5093e86?w=500&q=80", "Pro Marathoner", 244.99m },
                    { 62, 4, "High-performance Sprint Spike for serious runners.", "https://images.unsplash.com/photo-1581888748626-2a3f240a6f9f?w=500&q=80", "Sprint Spike", 247.49m },
                    { 63, 4, "High-performance Trail Blazer for serious runners.", "https://images.unsplash.com/photo-1709258228137-19a8c193be39?w=500&q=80", "Trail Blazer", 249.99m },
                    { 64, 4, "High-performance Cushion Cloud for serious runners.", "https://images.unsplash.com/photo-1597892657493-6847b9640bac?w=500&q=80", "Cushion Cloud", 252.49m },
                    { 65, 4, "High-performance Speed Demon for serious runners.", "https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500&q=80", "Speed Demon", 254.99m },
                    { 66, 4, "High-performance Endurance Pro for serious runners.", "https://images.unsplash.com/photo-1602190420103-683df5093e86?w=500&q=80", "Endurance Pro", 257.49m },
                    { 67, 4, "High-performance Morning Jogger for serious runners.", "https://images.unsplash.com/photo-1581888748626-2a3f240a6f9f?w=500&q=80", "Morning Jogger", 259.99m },
                    { 68, 4, "High-performance Track Star for serious runners.", "https://images.unsplash.com/photo-1709258228137-19a8c193be39?w=500&q=80", "Track Star", 262.49m },
                    { 69, 4, "High-performance Lite Racer for serious runners.", "https://images.unsplash.com/photo-1597892657493-6847b9640bac?w=500&q=80", "Lite Racer", 264.99m },
                    { 70, 4, "High-performance Impact Absorber for serious runners.", "https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500&q=80", "Impact Absorber", 267.49m },
                    { 71, 4, "High-performance Distance Runner for serious runners.", "https://images.unsplash.com/photo-1602190420103-683df5093e86?w=500&q=80", "Distance Runner", 269.99m },
                    { 72, 4, "High-performance Flex Sole for serious runners.", "https://images.unsplash.com/photo-1581888748626-2a3f240a6f9f?w=500&q=80", "Flex Sole", 272.49m },
                    { 73, 4, "High-performance Grip Master for serious runners.", "https://images.unsplash.com/photo-1709258228137-19a8c193be39?w=500&q=80", "Grip Master", 274.99m },
                    { 74, 4, "High-performance Aero Dynamic for serious runners.", "https://images.unsplash.com/photo-1597892657493-6847b9640bac?w=500&q=80", "Aero Dynamic", 277.49m },
                    { 75, 4, "High-performance Urban Sprinter for serious runners.", "https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500&q=80", "Urban Sprinter", 279.99m },
                    { 76, 4, "High-performance Night Runner for serious runners.", "https://images.unsplash.com/photo-1602190420103-683df5093e86?w=500&q=80", "Night Runner", 282.49m },
                    { 77, 4, "High-performance Terrain Master for serious runners.", "https://images.unsplash.com/photo-1581888748626-2a3f240a6f9f?w=500&q=80", "Terrain Master", 284.99m },
                    { 78, 4, "High-performance Velocity Max for serious runners.", "https://images.unsplash.com/photo-1709258228137-19a8c193be39?w=500&q=80", "Velocity Max", 287.49m },
                    { 79, 4, "High-performance Pace Setter for serious runners.", "https://images.unsplash.com/photo-1597892657493-6847b9640bac?w=500&q=80", "Pace Setter", 289.99m },
                    { 80, 4, "High-performance Zoom Elite for serious runners.", "https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500&q=80", "Zoom Elite", 292.49m }
                });

            migrationBuilder.CreateIndex(
                name: "IX_OrderItems_OrderId",
                table: "OrderItems",
                column: "OrderId");

            migrationBuilder.CreateIndex(
                name: "IX_OrderItems_ProductId",
                table: "OrderItems",
                column: "ProductId");

            migrationBuilder.CreateIndex(
                name: "IX_Orders_UserId",
                table: "Orders",
                column: "UserId");

            migrationBuilder.CreateIndex(
                name: "IX_Products_CategoryId",
                table: "Products",
                column: "CategoryId");
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "OrderItems");

            migrationBuilder.DropTable(
                name: "Orders");

            migrationBuilder.DropTable(
                name: "Products");

            migrationBuilder.DropTable(
                name: "Users");

            migrationBuilder.DropTable(
                name: "Categories");
        }
    }
}
