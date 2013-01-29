---
Title: Как создать нестандартную процедуру разбиения слов при переносах для TEdit, TMemo или TRichEdit?
Date: 01.01.2007
---


Как создать нестандартную процедуру разбиения слов при переносах для TEdit, TMemo или TRichEdit?
================================================================================================

::: {.date}
01.01.2007
:::

В следующем примере создается процедура разбиения слов при переносах для
TMemo. Заметьте, что реализованная процедура просто всегда разрешает
перенос. Для дополнительной информации см.таже документацию к сообщению
EM\_SETWORDBREAKPROC.

                  var 
                   OriginalWordBreakProc : pointer; 
                   NewWordBreakProc : pointer; 
     
                 function MyWordBreakProc(LPTSTR  : pchar; 
                                          ichCurrent : integer; 
                                          cch : integer; 
                                          code  : integer) : integer 
                    {$IFDEF WIN32} stdcall; {$ELSE} ; export; {$ENDIF} 
                 begin 
                   result :=  0; 
                 end; 
     
                 procedure TForm1.FormCreate(Sender: TObject); 
                 begin 
                   OriginalWordBreakProc := Pointer( 
                     SendMessage(Memo1.Handle, 
                                 EM_GETWORDBREAKPROC, 
                                 0, 
                                 0)); 
                  {$IFDEF WIN32} 
                   NewWordBreakProc := @MyWordBreakProc; 
                  {$ELSE} 
                    NewWordBreakProc := MakeProcInstance(@MyWordBreakProc, 
                                                         hInstance); 
                  {$ENDIF} 
                   SendMessage(Memo1.Handle, 
                               EM_SETWORDBREAKPROC, 
                               0, 
                               longint(NewWordBreakProc)); 
     
                 end; 
     
                 procedure TForm1.FormDestroy(Sender: TObject); 
                 begin 
                   SendMessage(Memo1.Handle, 
                               EM_SETWORDBREAKPROC, 
                               0, 
                               longint(@OriginalWordBreakProc)); 
                  {$IFNDEF WIN32} 
                    FreeProcInstance(NewWordBreakProc); 
                  {$ENDIF} 
                 end; 
