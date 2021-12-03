using Microsoft.EntityFrameworkCore.Migrations;

namespace testCodefirst.Migrations
{
    public partial class addClassRoom : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<int>(
                name: "ClassRoomID",
                table: "students",
                type: "int",
                nullable: true);

            migrationBuilder.CreateTable(
                name: "ClassRoom",
                columns: table => new
                {
                    ClassRoomID = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    ClassRoomName = table.Column<string>(type: "nvarchar(max)", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_ClassRoom", x => x.ClassRoomID);
                });

            migrationBuilder.CreateIndex(
                name: "IX_students_ClassRoomID",
                table: "students",
                column: "ClassRoomID");

            migrationBuilder.AddForeignKey(
                name: "FK_students_ClassRoom_ClassRoomID",
                table: "students",
                column: "ClassRoomID",
                principalTable: "ClassRoom",
                principalColumn: "ClassRoomID",
                onDelete: ReferentialAction.Restrict);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_students_ClassRoom_ClassRoomID",
                table: "students");

            migrationBuilder.DropTable(
                name: "ClassRoom");

            migrationBuilder.DropIndex(
                name: "IX_students_ClassRoomID",
                table: "students");

            migrationBuilder.DropColumn(
                name: "ClassRoomID",
                table: "students");
        }
    }
}
