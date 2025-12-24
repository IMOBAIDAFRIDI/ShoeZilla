using System.ComponentModel.DataAnnotations;

namespace ShoeZilla.Models
{
    public class Order
    {
        public int Id { get; set; }

        public int? UserId { get; set; } // Nullable for guest checkout if needed, or linked to registered user
        public User? User { get; set; }

        public DateTime OrderDate { get; set; } = DateTime.Now;

        [Required]
        public string CustomerName { get; set; } = string.Empty;

        [Required]
        [EmailAddress]
        public string CustomerEmail { get; set; } = string.Empty;

        [Required]
        public string ShippingAddress { get; set; } = string.Empty;

        public decimal TotalAmount { get; set; }

        public string PaymentMethod { get; set; } = "Card"; // "Card" or "COD"
        
        public string TrackingNumber { get; set; } = string.Empty;

        public string Status { get; set; } = "Pending"; // Pending, Processing, Shipped, Delivered, Cancelled

        public List<OrderItem> OrderItems { get; set; } = new List<OrderItem>();
    }
}
