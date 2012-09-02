<h1>Как сделать виртуальный диск?</h1>
<div class="date">01.01.2007</div>


<pre>
{ ... }
if DefineDosDevice(DDD_RAW_TARGET_PATH, 'P:', 'F:\Backup\Music\Modules') then
  ShowMessage('Drive was created successfully')
else
  ShowMessage('Error creating drive');
    { ... }
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
