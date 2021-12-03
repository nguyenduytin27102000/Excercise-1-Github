using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using testCodefirst.Models;

namespace testCodefirst.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class ClassRoomsApiController : ControllerBase
    {
        private readonly StudentDBContext _context = new StudentDBContext();

    

        // GET: api/ClassRoomsApi
        [HttpGet]
        public async Task<ActionResult<IEnumerable<ClassRoom>>> GetclassRooms()
        {
            return await _context.classRooms.ToListAsync();
        }

        // GET: api/ClassRoomsApi/5
        [HttpGet("{id}")]
        public async Task<ActionResult<ClassRoom>> GetClassRoom(int id)
        {
            var classRoom = await _context.classRooms.FindAsync(id);

            if (classRoom == null)
            {
                return NotFound();
            }

            return classRoom;
        }

        // PUT: api/ClassRoomsApi/5
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPut("{id}")]
        public async Task<IActionResult> PutClassRoom(int id, ClassRoom classRoom)
        {
            if (id != classRoom.ClassRoomID)
            {
                return BadRequest();
            }

            _context.Entry(classRoom).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!ClassRoomExists(id))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return NoContent();
        }

        // POST: api/ClassRoomsApi
        // To protect from overposting attacks, see https://go.microsoft.com/fwlink/?linkid=2123754
        [HttpPost]
        public async Task<ActionResult<ClassRoom>> PostClassRoom(ClassRoom classRoom)
        {
            _context.classRooms.Add(classRoom);
            await _context.SaveChangesAsync();

            return CreatedAtAction("GetClassRoom", new { id = classRoom.ClassRoomID }, classRoom);
        }

        // DELETE: api/ClassRoomsApi/5
        [HttpDelete("{id}")]
        public async Task<IActionResult> DeleteClassRoom(int id)
        {
            var classRoom = await _context.classRooms.FindAsync(id);
            if (classRoom == null)
            {
                return NotFound();
            }

            _context.classRooms.Remove(classRoom);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        private bool ClassRoomExists(int id)
        {
            return _context.classRooms.Any(e => e.ClassRoomID == id);
        }
    }
}
