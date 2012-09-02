<h1>Автоматический logon к локальной InterBase</h1>
<div class="date">01.01.2007</div>


<p>Используйте компонент TDatabase. В строках Params пропишите:</p>

<p> &nbsp;&nbsp;&nbsp; USER NAME=sysdba</p>
<p> &nbsp;&nbsp;&nbsp; PASSWORD=masterkey</p>

<p>Затем установите свойство компонента TDataBase LoginPrompt в False.</p>
<p>После этого, с помощью свойства DataBaseName, вы должны создать прикладной псевдоним (Alias) и связать TQuery/TTable с вашим компонентом TDataBase</p>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

