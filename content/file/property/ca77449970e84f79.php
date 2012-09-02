<h1>Как выяснить дату создания файла?</h1>
<div class="date">01.01.2007</div>

Попробуйте следующую функцию, которая не требует вызова FindFirst: </p>
<pre>
function GetFileDate(TheFileName: string): string;
var
  FHandle: integer;
begin
  FHandle := FileOpen(TheFileName, 0);
  result := DateTimeToStr(FileDateToDateTime(FileGetDate(FHandle)));
  FileClose(FHandle);
end;
</pre>
<p>Одно маленькое предупреждение: время, возвращаемое Win32-функцией, отсчитывается от Гринвича, поэтому вам необходимо привести полученный результат к локальному времени. Чтобы быть уверенным, проверьте документацию. (Я уверен, что FindNextFile делает это правильно). </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<p class="note">Примечание от Vit</p>
<p>Всё-таки лучше использовать FindFirst/FindNext/FindClose ибо приведенный выше способ требует открытия файла, а это не всегда возможно сделать (попробуйте например таким образом узнать дату создания файла подкачки!) и к тому же не всегда это желательно. В отличие от приведенного выше способа FindFirst не открывает файла, а лишь читает информацию с каталога диска, что и быстрее и надёжнее.</p>
