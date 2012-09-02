<h1>Как можно получить звук с помощью MediaPlayer?</h1>
<div class="date">01.01.2007</div>


<p>пример взят из рассылки "Мастера DELPHI. Новости мира компонент, FAQ, статьи..."</p>
<pre>procedure TForm1.btRecordClick(Sender: TObject);
begin
with Media do 
begin
{ Set FileName to the test.wav file to }
{ get the recording parameters. }
FileName := 'd:\test.wav';
{ Open the device. }
Open;
{ Start recording. }
Wait := False;
StartRecording;
end;
end;
procedure TForm1.btStopClick(Sender: TObject);
begin
with Media do 
begin
{ Stop recording. }
Stop;
{ Change the filename to the new file we want to write. }
FileName := 'd:\new.wav';
{ Save and close
the file. }
Save;
Close;
end;
end;
</pre>

<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

