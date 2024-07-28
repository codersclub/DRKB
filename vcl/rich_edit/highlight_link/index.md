---
Title: Подсветить ссылки в TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Подсветить ссылки в TRichEdit
=============================

    { 
      So what we need: 
      1. drop on your form a RichEdit component from win32 page of component 
      palette 
      2. in OnCreate event of your form write the next code: 
    }
     
     procedure TForm1.FormCreate(Sender: TObject);
     var
       mask: Word;
     begin
       mask := SendMessage(Handle, EM_GETEVENTMASK, 0, 0);
       SendMessage(RichEdit1.Handle, EM_SETEVENTMASK, 0, mask or ENM_LINK);
       SendMessage(RichEdit1.Handle, EM_AUTOURLDETECT, Integer(True), 0);
       RichEdit1.Text := 'SwissDelphiCenter.com: '#13#10 +
         ' Site is located at www.SwissDelphiCenter.com';
     end;
     
     { 
      After that your Richedit will convert automatically any URLs in highlighted 
      (blue color and underlined). Even if you'll start to enter any text directly 
      in Richedit, any begings for URL will be converted too (not only existing 
      text string but new too) 
    }
     
    // 3. now we must detect mouse clicks in URL range. For this task we must 
    //    override WndProc method of our form: 
    type
       TForm1 = class(TForm)
       protected
         procedure WndProc(var Message: TMessage); override;
       end;
     
    // 4. the implementation looks like this: 
     
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
     
    { 
     5. Now you can compile your project (don't forget to include Richedit and 
     ShellAPI units in uses clause). 
    }

