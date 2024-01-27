---
Title: Управление mIRC при помощи DDE
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Управление mIRC при помощи DDE
==============================

    uses
       DdeMan;
     
     procedure mIRCDDE(Service, Topic, Cmd: string);
     var
       DDE: TDDEClientConv;
     begin
       try
         DDE := TDDEClientConv.Create(nil);
         DDE.SetLink(Service, Topic);
         DDE.OpenLink;
         DDE.PokeData(Topic, PChar(Cmd));
       finally
         DDE.Free;
       end;
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       mIRCDDE('mIRC', 'COMMAND', '/say Hallo von SwissDelphiCenter.ch');
     end;

