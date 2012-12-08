---
Title: TListView в режиме отчета под манифестом XP
Date: 01.01.2007
---


TListView в режиме отчета под манифестом XP
===========================================

::: {.date}
01.01.2007
:::

    { 
      The TListView with a vsReport style causes an access violation 
      when you run your project with a XP manifest resource. 
     
      The VCL wrapper has a bug and you must patch sources. 
      Just copy the comctrls.pas unit in the folder with your own 
      project and modify the UpdateColumn method. 
      After compiling the project, a comctrls.dcu is created 
      and you can replace the original comctrls.dcu with the 
      patched one. 
     
    }
     
     { 
      Wenn ein XP Manifest als Ressource in eine Exe-Datei eingebunden 
      wird, um einer Applikation das neue XP-Design zu verleihen, 
      gibt es bei der TListView mit Style vsReport eine Zugriffsverletzung 
      und die Anwenung lasst sich nicht starten. 
     
      Das ist ein VCL Bug und kann behebt werden, indem 
      comctrls.pas modifiziert wird. 
      Kopiere die comctrls.pas in dein Projekte-Verzeichnis und 
      andere die UpdateColumn Methode wie folgt. 
      Nach dem Kompilieren wird eine Comctrls.dcu Datei erstellt. 
      Die original Comctrls.dcu kann nun durch die modifizierte ersetzt werden. 
    }
     
     
     // ComCtrls.pas: 
     
    procedure TCustomListView.UpdateColumn(AnIndex: Integer);
     {...}
     with Column, Columns.Items[AnIndex] do
     begin
       { PATCH start:}
       // mask := LVCF_TEXT or LVCF_FMT or LVCF_IMAGE; 
      mask := LVCF_TEXT or LVCF_FMT;
       if FImageIndex >= 0 then
         mask := mask or LVCF_IMAGE;
       { PATCH :end }
       {...}
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
