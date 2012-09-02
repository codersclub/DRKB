<h1>Сохранить TImageList в файл со всем содержимым</h1>
<div class="date">01.01.2007</div>


<pre>
// There are ready-made methods for saving any component including all its children to a file.
// For writing components use WriteComponentResFile(path + source filename , component name source)
 
WriteComponentResFile('C:\imagelist1.bin',imagelist1);
 
// For reading the data back to a component:
// component := ReadComponentResFile(path + source filename , component name traget)
 
imagelist1 := ReadComponentResFile('c:\imagelist1.bin', nil) as TImagelist;
 
// Tip 1 - Reading the component will give the same name of the component written so don't try to
// load it to another component, even if it was the same type. You will get a duplicate name and
// delphi will crash. But you can jump over this as a programmer
 
// Tip 2 - Get benfit of storing the heavy components inside compressed files,
// so you can get smaller programs
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
