<h1>Как узнать серийный номер Audio CD?</h1>
<div class="date">01.01.2007</div>



<p>CD может иметь или не иметь серийный номер и/или универсальный код продукта (Universal Product Code). MCI-расширение Windows предоставляет эту информации с помощью комманды MCI_INFO_MEDIA_IDENTITY command. Эта команда возвращает уникальную ID-строку.</p>
<p>Пример:</p>
<pre>
uses MMSystem, MPlayer;
 
procedure TForm1.Button1Click(Sender: TObject);
var
        mp : TMediaPlayer;
        msp : TMCI_INFO_PARMS;
        MediaString : array[0..255] of char;
        ret : longint;
begin
        mp := TMediaPlayer.Create(nil);
        mp.Visible := false;
        mp.Parent := Application.MainForm;
        mp.Shareable := true;
        mp.DeviceType := dtCDAudio;
        mp.FileName := 'D:';
        mp.Open;
        Application.ProcessMessages;
        FillChar(MediaString, sizeof(MediaString), #0);
        FillChar(msp, sizeof(msp), #0);
        msp.lpstrReturn := @MediaString;
        msp.dwRetSize := 255;
        ret := mciSendCommand(Mp.DeviceId, MCI_INFO, MCI_INFO_MEDIA_IDENTITY,
                        longint(@msp));
        if Ret &lt;&gt; 0 then
                begin
                        MciGetErrorString(ret, @MediaString, sizeof(MediaString));
                        Memo1.Lines.Add(StrPas(MediaString));
                end
        else
                Memo1.Lines.Add(StrPas(MediaString));
        mp.Close;
        Application.ProcessMessages;
        mp.free;
end;
end.
</pre>

<p>Взято из</p>
DELPHI VCL FAQ Перевод с английского &nbsp; &nbsp; &nbsp; 
<p>Подборку, перевод и адаптацию материала подготовил Aziz(JINX)</p>
<p>специально для <a href="https://delphi.vitpc.com/" target="_blank">Королевства Дельфи</a></p>


