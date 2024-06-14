---
Title: Как показать видео на полном экране?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как показать видео на полном экране?
====================================

    procedure TForm1.Button1Click(Sender: TObject);
    const
      longName: PChar = 'f:\media\ANIM1.MPG'; {Your complete FileName}
    var
      ret, shortName: PChar;
      err: DWord;
    begin
      {Getting the short Name (8:3) of selected file}
      shortName := strAlloc(521);
      GetShortPathName(longName, shortname, 512);
      {Sending a close Command to the MCI}
      ret := strAlloc(255);
      err := mciSendString(pchar('close movie'), 0, 0, 0);
      {No error check because at the first call there is no MCI device to close}
      {Open a new MCI Device with the selected movie file}
      err := mciSendString(pchar('open ' + shortName + ' alias movie'), 0, 0, 0);
      shortName := nil;
      {If an Error was traced then display a MessageBox with the mciError string}
      if err <> 0 then
      begin
        mciGetErrorString(err, ret, 255);
        messageDlg(ret, mtInformation, [mbOk], 0);
      end;
      {Sending the "play fullscreen command to the Windows MCI}
      err := mciSendString(pchar('play movie fullscreen'), 0, 0, 0);
      {Use the following line instead of the above one if you want to play 
            it in screen mode}
      err := mciSendString(pchar('play movie'), 0, 0, 0);
      {If an Error was traced then display a MessageBox with the mciError string}
      if err <> 0 then
      begin
        mciGetErrorString(err, ret, 255);
        messageDlg(ret, mtInformation, [mbOk], 0);
      end;
      ret := nil;
    end;

