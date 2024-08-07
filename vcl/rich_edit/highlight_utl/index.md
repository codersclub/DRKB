---
Title: Как выделить URL в TRichEdit?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как выделить URL в TRichEdit?
=============================

    {....}
     
      protected
        procedure WndProc(var Message: TMessage); override;
     
    {....}
     
     
    uses Richedit, ShellApi;
     
    {Today I want to show how to implement URL highlighting and URL navigation
    without any third-party components. This functionality is implemented in
    RichEdit from Microsoft (and MS Outlook use this feature, for example) and
    only Borland's developers didn't publish it for us.}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      mask: Word;
    begin
      mask := SendMessage(RichEdit1.Handle, EM_GETEVENTMASK, 0, 0);
      SendMessage(RichEdit1.Handle, EM_SETEVENTMASK, 0, mask or ENM_LINK);
      SendMessage(RichEdit1.Handle, EM_AUTOURLDETECT, Integer(True), 0);
     
      //Some text in RichEdit
      RichEdit1.Text := 'Scalabium Software'#13#10 +
        ' Site is located at www.scalabium.com. Welcome to our site.';
    end;
     
    procedure TForm1.WndProc(var Message: TMessage);
    var
      p: TENLink;
      strURL: string;
    begin
      if (Message.Msg = WM_NOTIFY) then
      begin
        if (PNMHDR(Message.lParam).code = EN_LINK) then
        begin
          p := TENLink(Pointer(TWMNotify(Message).NMHdr)^);
          if (p.Msg = WM_LBUTTONDOWN) then
          begin
            SendMessage(RichEdit1.Handle, EM_EXSETSEL, 0, Longint(@(p.chrg)));
            strURL := RichEdit1.SelText;
            ShellExecute(Handle, 'open', PChar(strURL), 0, 0, SW_SHOWNORMAL);
          end
        end
      end;
     
      inherited;
    end;

