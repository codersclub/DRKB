<h1>Добавить событие OnDblClick на заголовке TListView</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  MS did not see fit to send a notification to the listview when the user 
  Double - clicks on the header. But the header control class does have the 
  CS_DBLCLKS Style, so it does get WM_LBUTTONDBLCLK messages, it just does 
  not do anything with them. To get at these messages requires API - Style 
  subclassing of the header control. 
}
 
 uses commctrl;
 
 
 function HeaderProc(wnd: HWND; Msg: Cardinal; wParam: wParam; lParam: lParam): Longint;
   stdcall;
 var
   hti: THDHitTestInfo;
 begin
   Result := CallWindowProc(Pointer(GetWindowLong(wnd, GWL_USERDATA)),
     wnd, Msg, wParam, lParam);
   if Msg = WM_LBUTTONDBLCLK then
   begin
     FillChar(hti, SizeOf(hti), 0);
     hti.Point := SmallPointToPoint(TSmallPoint(lParam));
     if SendMessage(wnd, HDM_HITTEST, 0, Longint(@hti)) &gt;= 0 then
       if hti.Flags = HHT_ONHEADER then
         // would usually send a custom notification to GetParent(wnd) here 
        Form1.Memo1.Lines.Add(Format('doubleclick on header item %d', [hti.Item]));
   end;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 var
   wnd: HWND;
   buffer: array [0..80] of Char;
   oldProc: Integer;
 begin
   wnd := GetWindow(Listview1.Handle, GW_CHILD);
   if wnd &lt;&gt; 0 then
   begin
     Windows.GetClassname(wnd, buffer, SizeOf(buffer));
     memo1.Text := buffer;
     if (GetClassLong(wnd, GCL_STYLE) and CS_DBLCLKS) &lt;&gt; 0 then
     begin
       Memo1.Lines.Add('Has doubleclicks style');
       oldproc := GetWIndowLong(wnd, GWL_WNDPROC);
       if GetWindowLong(wnd, GWL_USERDATA) &lt;&gt; 0 then
         raise Exception.Create('Cannot sublcass header, USERDATA already in use');
       SetWIndowLong(wnd, GWL_USERDATA, oldproc);
       SetWindowLong(wnd, GWL_WNDPROC, Integer(@HeaderProc));
     end;
   end
   else
     Memo1.Text := 'No child';
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
