using System.Collections;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace testCodefirst.Models
{
    [Table("ClassRoom")]
    public class ClassRoom
    {
        [Key]
        public int ClassRoomID { get; set; }
        public string ClassRoomName { get; set; }
        public virtual ICollection<Student> Students { get; set; }
    }
}
