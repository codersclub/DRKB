<h1>Дата в SQL запросах в MS Access</h1>
<div class="date">01.01.2007</div>


<p>Для дат используйте #:</p>
<pre>
SELECT Students.Name,Students.BirthDate,Teachers.Name 
FROM Teachers 
INNER JOIN Students ON Students.TeacherID=Teachers.ID 
WHERE Students.BirthDate BETWEEN #09/02/87# AND #01/01/00#
</pre>
<div class="author">Автор: Vit</div>
