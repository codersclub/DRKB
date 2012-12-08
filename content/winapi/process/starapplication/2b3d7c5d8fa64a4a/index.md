---
Title: Запустить приложение с помощью ShellExecute и подождать
Date: 01.01.2007
---

Запустить приложение с помощью ShellExecute и подождать
=======================================================

::: {.date}
01.01.2007
:::

     Var
       exInfo: TShellExecuteInfo;
     Begin
       FillChar( exInfo, Sizeof(exInfo), 0 );
       With exInfo Do Begin
         cbSize:= Sizeof( exInfo ); // required!
         fMask := SEE_MASK_NOCLOSEPROCESS;
         Wnd   := Handle;  // forms handle
         lpVerb:= 'paintto';
         lpFile:= Pchar( pdffilename );
         lpParameters := PChar( printernameAndPort );
         nShow := SW_HIDE;
       End;
       If ShellExecuteEx( @exInfo ) Then Begin
          While GetExitCodeProcess( exinfo.hProcess, exitcode )
                and (exitcode = STILL_ACTIVE)
          Do
            Sleep( 500 );
          CloseHandle( exinfo.hProcess );
          DeleteFile( pdffilename );
       End
       Else
         ShowMessage(SysErrorMessage( GetLastError ));
