using System.ComponentModel.DataAnnotations;

namespace ShoeZilla.Models
{
    public class User
    {
        public int Id { get; set; }

        [Required]
        public string FullName { get; set; } = string.Empty;

        [Required]
        [EmailAddress]
        public string Email { get; set; } = string.Empty;

        [Required]
        public string Password { get; set; } = string.Empty; // Storing plain text for simplicity as per prototype context, but ideally hashed.

        public string Role { get; set; } = "User"; // "Admin" or "User"

        public decimal Salary { get; set; }
        public string Designation { get; set; } = string.Empty;

        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }
}
