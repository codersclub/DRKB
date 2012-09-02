<h1>Компиляция ресурсов</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Ralph Friedman&nbsp; </p>

<p>У меня имеется приблизительно 36 маленьких растровых изображений, которые я хочу сохранить в файле и затем прилинковать его к exe. Как мне поместить их в res-файл? </p>

<p>Самый простой путь - создать файл с именем "BITMAPS.RC" и поместить в него список ваших .BMP-файлов:</p>

<p>BMAP1 BITMAP BMAP1.BMP</p>
<p>BMAP2 BITMAP BMAP2.BMP</p>
<p>CLOCK BITMAP CLOCK.BMP</p>
<p>DBLCK BITMAP DBLCK.BMP</p>
<p>DELOK BITMAP DELOK.BMP</p>
<p>LUPE BITMAP LUPE.BMP</p>
<p>OK BITMAP OK.BMP</p>
<p>TIMEEDIT BITMAP TIMEEDIT.BMP</p>

<p>Затем загрузите Resource Workshop (RW) и выберите пункт меню File|Project Open. В выпадающем списке "File Type" (тип файла) выберите RC-Resource Script и откройте файл, который вы только что создали. После того, как RW загрузит ваш файл, выберите пункт меню File|Project save as. Выберите объект RES-Resource из выпадающего списка "File Type" (тип файла). В поле редактирования "New File name" задайте имя нового файла, скажем, BITMAPS.RES. Нажмите OK. Теперь у вас есть файл ресурса. В вашем модуле Delphi добавьте после строки {$R *.RES} строку {$R BITMAPS.RES}. После компиляции вы получите exe-файл с скомпилированными ресурсами. Для получения доступа к ресурсам во время выполнения программы нужно сделать следующее: </p>

<pre>
myImage.Picture.Bitmap.Handle := LoadBitmap(HInstance, 'TIMEEDIT');
</pre>

<p>В качестве предостережения: убедитесь в том, что имена (в самой левой колонке) изображений в .RC файле написаны в верхнем регистре, при вызове также необходимо писать их имена в верхнем регистре.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

