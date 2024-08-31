---
Title: Активизация или отключение автоматического проигрывания CD
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Активизация или отключение автоматического проигрывания CD
==========================================================

    uses
       Registry;
     
     procedure CDSetAutoPlay(SioNo: Boolean);
     var
       Reg: TRegistry;
     begin
       try
         Reg := TRegistry.Create;
         Reg.RootKey := HKEY_LOCAL_MACHINE;
         if Reg.KeyExists('Software\Classes\AudioCD\') then
           if Reg.OpenKey('Software\Classes\AudioCD\Shell\', False) then
             if SioNo then Reg.WriteString('', 'play')
             else
                Reg.WriteString('', '');
       finally
         Reg.Free;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       {Activate  AutoPlay}
       CDSetAutoPlay(True);
     end;
     
     procedure TForm1.Button2Click(Sender: TObject);
     begin
       {Deactivate Autoplay}
       CDSetAutoPlay(False);
     end;

