
using System.ComponentModel.DataAnnotations;

namespace ShoeZilla.Models
{
    public class Category
    {
        public int Id { get; set; }

        [Required]
        [Display(Name = "Category Name")]
        public string Name { get; set; } = string.Empty;

        // Navigation property for related products (optional but good for EF)
        public ICollection<Product>? Products { get; set; }
    }
}
