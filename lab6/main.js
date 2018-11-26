let students;
let lessons;
var lessonSeat = {};
var enrolledSeat = {};

let activeStudent;

window.onload = () => {
	btn = document.getElementById("confirm-btn");
}

(() => {
	students = $.getJSON('./student.json', (data) => {

		$.each(data, function (key, val) {
			$("#student-table tbody").append(`<tr onClick="studentClick(this)">
					<th class="sisi_id" scope="row" >${val["SisiId"]}</th>
					<td>${val["Name"]}</td>
					<td>${val["Program"]}</td>
				</tr>`);
		});
		students = students.responseJSON;
	});
})();

(() => {
	lessons = $.getJSON('./lesson.json', (data) => {

		$.each(data, function (key, val) {
			lessonSeat = Object.assign({}, lessonSeat, {
				[val["LessonIndex"]]: val["Seat"]
			});
			enrolledSeat = Object.assign({}, enrolledSeat, {
				[val["LessonIndex"]]: {
					max: lessonSeat[val["LessonIndex"]],
					enrolled: 0
				}
			});

			$("#lesson-table tbody").append(`<tr>
					<th class="lesson_index" scope="row" >${val["LessonIndex"]}</th>
					<td>${val["Name"]}</td>
					<td>${val["Credit"]}</td>
					<td><button disabled onClick="lessonClick(this)">Disable</button></td>
				</tr>`);
		});

		lessons = lessons.responseJSON;

		for (const key in students) {
			students[key].lesson.forEach((lesson_index) => {
				enrolledSeat[lesson_index].enrolled++;
			})
		}
	});
})();

function studentClick(tag) {
	let sisi_id = tag.querySelector('.sisi_id').textContent;

	if (activeStudent && sisi_id != activeStudent.SisiId) {
		$("#show").empty();
	}

	activeStudent = students[sisi_id];
	renderLessonTable(activeStudent);

	if (btn && activeStudent) {
		btn.addEventListener("click", () => {
			$("#show").empty();
			output = '';
			output = JSON.stringify({ [activeStudent.SisiId]: activeStudent.lesson });
			$("#show").append(output);
		}, false);
	}
}

function lessonClickCancel(lesson) {
	lesson_index = lesson.parentElement.parentElement.querySelector("th").textContent;
	activeStudent.lesson = activeStudent.lesson.filter(e => e != lesson_index);
	enrolledSeat[lesson_index].enrolled--;
	renderLessonTable(activeStudent);
}

function lessonClickEnroll(lesson) {
	lesson_index = lesson.parentElement.parentElement.querySelector("th").textContent;
	activeStudent.lesson.push(lesson_index);
	enrolledSeat[lesson_index].enrolled++;
	renderLessonTable(activeStudent);
}

function renderLessonTable(activeStudent) {
	$("#student-name").html('<h4>' + activeStudent.Name + '</h4>');
	$("#lesson-table tbody tr").each((i, obj) => {
		new_obj = '';
		lesson_index = obj.querySelector("th").textContent;
		if (activeStudent.lesson.includes(lesson_index)) {
			new_obj = '<button class="cancel-btn" onClick="lessonClickCancel(this)">CANCEL</button>';
		} else if (!isSeatOpen(lesson_index)) {
			new_obj = '<button class="full-btn" disabled onClick="">FULL</button>';
		} else if (isCreditOver(activeStudent, lesson_index)) {
			new_obj = '<button class="full-btn" disabled onClick="">CREDIT FULL</button>';
		} else {
			new_obj = '<button class="enroll-btn" onClick="lessonClickEnroll(this)">ENROLL</button>';
		}
		document.getElementById("lesson-table").getElementsByTagName("button")[i].parentElement.innerHTML = new_obj;
	});
}

function isSeatOpen(lesson_index) {
	if (enrolledSeat[lesson_index].enrolled >= enrolledSeat[lesson_index].max) {
		return false;
	}
	return true;
}

function isCreditOver(activeStudent, lesson_index) {
	let sum = activeStudent.lesson.reduce((total, lesson_index_inside) => {
		return total + lessons[lesson_index_inside].Credit;
	}, 0);

	if ((sum + lessons[lesson_index].Credit) > 21) {
		return true;
	}

	return false;
}

$("#confirm-btn").click(() => {
	output = JSON.stringify({ [activeStudent[sisi_id]]: 0 })

	console.log(output)

	$("#show").append(output);
});


