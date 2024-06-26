---
Title: Как экстрагировать аудиодорожку из AVI файла?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>

---


Как экстрагировать аудиодорожку из AVI файла?
=============================================

    uses 
    {...}, vfw; 
     
    var 
      abort: Boolean; 
     
      {$R *.DFM} 
     
    {Special thanks to Jailbird, who developed a big part of this Code 
    Please download th vfw.pas first } 
    {The 'SaveCallback' function allows the user to get the 
     process status and abort the save progress. This function 
     needn't to call by the user.} 
     
    function SaveCallback(nPercent: Int): Bool; pascal; 
    begin 
      Application.ProcessMessages; 
     
      Form1.Progressbar1.Position := nPercent; 
      //Save Status in Percent 
      if abort = True then 
        Result := True    
      else                //If then function returns "True", the Process will continue 
        Result := False;  
    end;                  //If it returns "False" the process will abort 
     
    {The following function needs two parameters: 
     
     InputFile: PChar 
      Enter a Dir + Filename of a AVI File. 
     
     OutputFile: PChar 
      Enter a Dir + Filename of a WAVE File where do you want to 
      put the audiodata of the movie. 
     
      TIP: 
      Enter jus a Filename of a WAVE File if the audiodata of the 
      movie is in uncompressed PCM Format. 
     
     ########################################################### 
     
     IMPORTANT: 
      Before calling the 'ExtractAVISound' function be sure that the 
      Inputfile has a audiotrace. 
     } 
     
    function TForm1.ExtractAVISound(InputFile, Outputfile: PChar): Boolean; 
    var 
      PFile: IAviFile; 
      PAvi: IAviStream; 
      plpOptions: PAviCompressOptions; 
    begin 
      Abort := False; 
     
      if Fileexists(StrPas(Outputfile)) then  
      begin 
        case MessageDlg('Ausgabedatei existiert bereits. Ьberschreiben?', 
          mtWarning, [mbYes, mbNo], 0) of 
          mrYes:  
            begin 
              DeleteFile(StrPas(Outputfile)); 
            end;                             
          //Important because the function overwrite just 
          //the part of the file which is needed. 
          mrNo:  
            begin 
              Exit; 
            end; 
        end; 
      end; 
     
      try            
        AviFileInit;  //Init the API 
        if AviFileOpen(PFile, Inputfile, 0, nil) <> 0 then  
        begin                                               //Opens a AVI File 
          MessageDlg('Fehler beim laden des Videos. 
          Mцglicherweise wird die Datei von einem anderen Prozess verwendet.' 
            + #13#10 + 
            'SchlieЯen Sie alle in Frage kommenden Anwendungen und versuchen Sie es erneut.', 
            mtError, [mbOK], 0); 
          Result := False; 
          Exit; 
        end; 
        if AviFileGetStream(PFile, PAvi, StreamTypeAudio, 0) <> 0 then 
        begin 
          MessageDlg( 
            'Fehler beim laden des AudioStreams. Bitte ьberprьfen Sie, ob dieses Video ьber einen AudioStream verfьgt.', 
            mtError, [mbOK], 0); 
          AviFileExit; 
          Result := False; 
          Exit; 
        end; 
        //Saves the AudioStream 
        if AviSaveV(Outputfile, nil, @SaveCallback, 1, PAvi, plpOptions) <> 0 then 
        begin 
          MessageDlg('Fehler beim Speichern des AudioStreams oder Sie haben den Speichervorgang abgebrochen.', 
            mtError, [mbOK], 0); 
          AviStreamRelease(PAvi); 
          AviFileExit; 
          Result := False; 
          Exit; 
        end; 
      finally 
        AviStreamRelease(PAvi); 
        AviFileExit; 
      end; 
      Result := True;  
      //return 'TRUE' if all right 
    end; 
     
    //Example how to call the function: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if ExtractAVISound(PChar('D:\test.avi'), PChar('D:\test.wav')) = True then 
        ShowMessage('Audio sucessfully saved'); 
      else 
        ShowMessage('Error while saving...'); 
    end; 
