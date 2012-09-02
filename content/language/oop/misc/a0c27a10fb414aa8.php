<h1>Работа метода Assign</h1>
<div class="date">01.01.2007</div>


<p>В общем случае, утверждение "Destination := Source" не идентично утверждению "Destination.Assign(Source)".</p>

<p>Утверждение "Destination := Source" принуждает Destination ссылаться на тот же объект, что и Source, а "Destination.Assign(Source)" копирует содержание объектных ссылок Source в объектные ссылки Destination.</p>

<p>Если Destination является свойством некоторого объекта (тем не менее, и свойство не является ссылкой на другой объект, как, например, свойство формы ActiveControl, или свойство DataSource элементов управления для работы с базами данных), тогда утверждение "Destination := Source" идентично утверждению "Destination.Assign(Source)". Это объясняет, почему LB.Items := MemStr работает, когда MemStr := LB.Items нет. </p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

