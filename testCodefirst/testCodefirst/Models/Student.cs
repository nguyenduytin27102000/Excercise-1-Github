using System.ComponentModel.DataAnnotations.Schema;

namespace testCodefirst.Models
{
    public class Student
    {
        public int StudentID { get; set; }
        public string Name { get; set; }
        public int Age { get; set; }
        public int? ClassRoomID { get; set; }
        [ForeignKey("ClassRoomID")]
        public ClassRoom ClassRoom { get; set; }
    }
}
