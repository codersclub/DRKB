<h1>Запустить приложение с помощью ShellExecute и подождать</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

