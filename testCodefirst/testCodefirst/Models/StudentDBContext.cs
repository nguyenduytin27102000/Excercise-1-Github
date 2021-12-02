using Microsoft.EntityFrameworkCore;

namespace testCodefirst.Models
{
    public class StudentDBContext : DbContext
    {
        public DbSet<Student> students { get; set; }
        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            optionsBuilder.UseSqlServer(@"Data Source=SONIC;Initial Catalog=StudentDB;User ID=sa;Password=123456");
        }
    }
}
