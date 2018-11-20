let student;
let lesson;

let activeStudent;

(() => {
	student = $.getJSON('./student.json', (data) => {

		$.each(data, function (key, val) {
			$("#student-table tbody").append(`<tr onClick="studentClick(this)">
					<th class="sisi_id" scope="row" >${val["SisiId"]}</th>
					<td>${val["Name"]}</td>
					<td>${val["Program"]}</td>
				</tr>`);
		});
	});
})();

(() => {
	lesson = $.getJSON('./lesson.json', (data) => {

		$.each(data, function (key, val) {
			$("#lesson-table tbody").append(`<tr>
					<th class="lesson_index" scope="row" >${val["LessonIndex"]}</th>
					<td>${val["Name"]}</td>
					<td>${val["Credit"]}</td>
					<td><buton>Disable</button></td>
				</tr>`);
		});
	});
})();

function studentClick(tag) {
	let sisi_id = tag.querySelector('.sisi_id').textContent;
	activeStudent = student.responseJSON[sisi_id];
	renderLessonTable(sisi_id);
}
function lessonClick(tag) {
	console.log(tag.parentElement.parentElement);
}

function renderLessonTable(sisi_id) {

}


