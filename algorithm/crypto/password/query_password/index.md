---
Title: Запрос пароля при инициализации приложения
Author: Xavier Pacheco
Date: 01.01.1999
---


Запрос пароля при инициализации приложения
==========================================

    {
    Copyright © 1998 by Delphi 4 Developer's Guide - Xavier Pacheco and Steve Teixeira
    }
     
    program Initialize;
     
    uses
      Forms,
      Dialogs,
      Controls,
      MainFrm in 'MainFrm.pas' {MainForm};
     
    {$R *.RES}
     
    var
      Password: string;
    begin
      if InputQuery('Password', 'Enter your password', PassWord) then
        if Password = 'D5DG' then
        begin
          // Other initialization routines can go here.
          Application.CreateForm(TMainForm, MainForm);
          Application.Run;
        end
        else
          MessageDlg('Incorrect Password, terminating program', mtError, [mbok], 0);
    end.
