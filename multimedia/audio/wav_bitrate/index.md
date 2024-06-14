---
Title: Как определить bitrate WAV файла?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как определить bitrate WAV файла?
=================================

    {....} 
     
      private 
        procedure OpenMedia(WaveFile : string); 
        function GetStatus(StatusRequested : DWord) : longint; 
        procedure CloseMedia; 
     
    {....} 
     
    var 
      MyError, dwFlags: Longint; 
      FDeviceID : Word; 
     
    {....} 
     
    uses 
      MMSystem; 
     
    {....} 
     
    procedure TForm1.OpenMedia(WaveFile: string); 
    var 
      MyOpenParms: TMCI_Open_Parms; 
    begin 
      with MyOpenParms do 
      begin 
        dwCallback       := Handle; // TForm1.Handle 
        lpstrDeviceType  := PChar('WaveAudio'); 
        lpstrElementName := PChar(WaveFile); 
      end; {with MyOpenParms} 
      dwFlags := MCI_WAIT or MCI_OPEN_ELEMENT or MCI_OPEN_TYPE; 
      MyError := mciSendCommand(0, MCI_OPEN, dwFlags, Longint(@MyOpenParms)); 
      // one could use mciSendCommand(DevId, here to specify a particular device 
      if MyError = 0 then 
        FDeviceID := MyOpenParms.wDeviceID 
      else 
        raise Exception.Create('Open Failed'); 
    end; 
     
    function TForm1.GetStatus(StatusRequested: DWORD): Longint; 
    var 
      MyStatusParms: TMCI_Status_Parms; 
    begin 
      dwFlags := MCI_WAIT or MCI_STATUS_ITEM; 
      with MyStatusParms do 
      begin 
        dwCallback := Handle; 
        dwItem     := StatusRequested; 
      end; 
      MyError := mciSendCommand(FDeviceID, 
        MCI_STATUS, 
        MCI_WAIT or MCI_STATUS_ITEM, 
        Longint(@MyStatusParms)); 
      if MyError = 0 then 
        Result := MyStatusParms.dwReturn 
      else 
        raise Exception.Create('Status call to get status of ' + 
          IntToStr(StatusRequested) + ' Failed'); 
    end; 
     
    procedure TForm1.CloseMedia; 
    var 
      MyGenParms: TMCI_Generic_Parms; 
    begin 
      if FDeviceID > 0 then 
      begin 
        dwFlags := 0; 
        MyGenParms.dwCallback := Handle; // TForm1.Handle 
        MyError := mciSendCommand(FDeviceID, MCI_CLOSE, dwFlags, Longint(@MyGenParms)); 
        if MyError = 0 then 
          FDeviceID := 0 
        else 
        begin 
          raise Exception.Create('Close Failed'); 
        end; 
      end; 
    end; 
     
     
    //Example: 
    //Beispiel: 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      if OpenDialog1.Execute then 
      begin 
        OpenMedia(OpenDialog1.FileName); 
        with ListBox1.Items do 
        begin 
          Add('Average Bytes / Sec : ' + IntToStr(GetStatus(MCI_WAVE_STATUS_AVGBYTESPERSEC))); 
          Add('Bits / Sample : ' + IntToStr(GetStatus(MCI_WAVE_STATUS_BITSPERSAMPLE))); 
          Add('Samples / Sec : ' + IntToStr(GetStatus(MCI_WAVE_STATUS_SAMPLESPERSEC))); 
          Add('Channels : ' + IntToStr(GetStatus(MCI_WAVE_STATUS_CHANNELS))); 
        end; 
        CloseMedia; 
      end; 
    end; 

