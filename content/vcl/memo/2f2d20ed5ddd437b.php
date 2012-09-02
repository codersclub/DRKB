<h1>Програмная навигация в TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
{************************************************************
 * Procedure PostKeyEx
 *
 * Parameters:
 *  hWindow: target window to be send the keystroke
 *  key    : virtual keycode of the key to send. For printable
 *           keys this is usually the ANSI code (Ord(character))
 *           of the UPPERCASE character. See VkKeyScan to obtain
 *           the virtual key codes of other characters.
 *  shift  : state of the modifier keys. This is a set, so you
 *           can set several of these keys (shift, control, alt,
 *           mouse buttons) in tandem. The TShiftState type is
 *           declared in the Classes Unit.
 *  specialkey: normally this should be False. Set it to True to
 *           specify a key on the numeric keypad, for example.
 *           If this parameter is true, bit 24 of the lparam for
 *           the posted WM_KEY* messages will be set.
 * Description:
 *  This procedure sets up Windows key state array to correctly
 *  reflect the requested pattern of modifier keys and then posts
 *  a WM_KEYDOWN/WM_KEYUP message pair to the target window. Then
 *  Application.ProcessMessages is called to process the messages
 *  before the keyboard state is restored.
 * Error Conditions:
 *  May fail due to lack of memory for the two key state buffers.
 *  Will raise an exception in this case.
 * NOTE:
 *  Setting the keyboard state will not work across applications
 *  running in different memory spaces on Win32.
 *Created: 02/21/96 16:39:00 by P. Below
 ************************************************************}
Procedure PostKeyEx( hWindow: HWnd; key: Word; Const shift: TShiftState;
                     specialkey: Boolean );
Type
  TBuffers = Array [0..1] of TKeyboardState;
Var
  pKeyBuffers : ^TBuffers;
  lparam: LongInt;
Begin
  (* check if the target window exists *)
  If IsWindow(hWindow) Then Begin
    (* set local variables to default values *)
    pKeyBuffers := Nil;
    lparam := MakeLong(0, MapVirtualKey(key, 0));
    (* modify lparam if special key requested *)
    If specialkey Then
      lparam := lparam or $1000000;
    (* allocate space for the key state buffers *)
    New(pKeyBuffers);
    try
      (* Fill buffer 1 with current state so we can later restore it.
         Null out buffer 0 to get a "no key pressed" state. *)
      GetKeyboardState( pKeyBuffers^[1] );
      FillChar(pKeyBuffers^[0], Sizeof(TKeyboardState), 0);
      (* set the requested modifier keys to "down" state in the buffer *)
      If ssShift In shift Then
        pKeyBuffers^[0][VK_SHIFT] := $80;
      If ssAlt In shift Then Begin
        (* Alt needs special treatment since a bit in lparam needs also be
set *)
        pKeyBuffers^[0][VK_MENU] := $80;
        lparam := lparam or $20000000;
      End;
      If ssCtrl In shift Then
        pKeyBuffers^[0][VK_CONTROL] := $80;
      If ssLeft In shift Then
        pKeyBuffers^[0][VK_LBUTTON] := $80;
      If ssRight In shift Then
        pKeyBuffers^[0][VK_RBUTTON] := $80;
      If ssMiddle In shift Then
        pKeyBuffers^[0][VK_MBUTTON] := $80;
      (* make out new key state array the active key state map *)
 
      SetKeyboardState( pKeyBuffers^[0] );
 
      (* post the key messages *)
      If ssAlt In Shift Then Begin
        PostMessage( hWindow, WM_SYSKEYDOWN, key, lparam);
        PostMessage( hWindow, WM_SYSKEYUP, key, lparam or $C0000000);
      End
      Else Begin
        PostMessage( hWindow, WM_KEYDOWN, key, lparam);
        PostMessage( hWindow, WM_KEYUP, key, lparam or $C0000000);
      End;
      (* process the messages *)
      Application.ProcessMessages;
      (* restore the old key state map *)
      SetKeyboardState( pKeyBuffers^[1] );
    finally
      (* free the memory for the key state buffers *)
      If pKeyBuffers &lt;&gt; Nil Then
        Dispose( pKeyBuffers );
    End; { If }
  End;
End; { PostKeyEx }
</pre>

Пример:</p>
&nbsp;</p>
<pre>
procedure TForm1.SpeedButton2Click(Sender: TObject);
Var
  W: HWnd;
begin
  W := Memo1.Handle;
  PostKeyEx( W, VK_END, [ssCtrl, ssShift], False ); {select all}
  PostKeyEx( W, Ord('C'), [ssCtrl], False );        {copy to clipboard}
  PostKeyEx( W, Ord('C'), [ssShift], False );       {replace with C}
  PostKeyEx( W, VK_RETURN, [], False );             {new line}
  PostKeyEx( W, VK_END, [], False );                {goto end}
  PostKeyEx( W, Ord('V'), [ssCtrl], False );        {paste from keyboard}
end;
</pre>

