---
Title: Как можно получить звук с помощью MediaPlayer?
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как можно получить звук с помощью MediaPlayer?
==============================================

пример взят из рассылки "Мастера DELPHI. Новости мира компонент, FAQ,
статьи..."

    procedure TForm1.btRecordClick(Sender: TObject);
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

