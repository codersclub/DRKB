<h1>Помещение формы в поток</h1>
<div class="date">01.01.2007</div>


<p>Delphi имеет в своем распоряжении классную функцию, позволяющую сделать это:</p>
<pre>
procedure WriteComponentResFile(const FileName: string;
 Instance: TComponent);
</pre>
<p>Просто заполните имя файла, в котором вы хотите сохранить компонент, и читайте его затем следующей функцией:</p>
<pre>
function ReadComponentResFile(const FileName: string;
 Instance: TComponent): TComponent;
</pre>

<div class="author">Автор: Slawanix</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
