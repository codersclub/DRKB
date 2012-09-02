<h1>Объединение двух иконок</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  I want to combine 2 icons like Windows does with 
  the links (the small arrow). 
  Can anyone tell me how that works? 
}
 
 function CombineIcons(FrontIcon, BackIcon: HIcon): HIcon;
 var
   WinDC: HDC;
   FrontInfo: TIconInfo;
   FrontDC: HDC;
   FrontSv: HBITMAP;
   BackInfo: TIconInfo;
   BackDC: HDC;
   BackSv: HBITMAP;
   BmpObj: tagBitmap;
 begin
   WinDC := GetDC(0);
 
   GetIconInfo(FrontIcon, FrontInfo);
   FrontDC := CreateCompatibleDC(WinDC);
   FrontSv := SelectObject(FrontDC, FrontInfo.hbmMask);
 
   GetIconInfo(BackIcon, BackInfo);
   BackDC := CreateCompatibleDC(WinDC);
   BackSv := SelectObject(BackDC, BackInfo.hbmMask);
 
   GetObject(FrontInfo.hbmMask, SizeOf(BmpObj), @BmpObj);
   BitBlt(BackDC, 0,0,BmpObj.bmWidth, BmpObj.bmHeight, FrontDC, 0,0,SRCAND);
 
   SelectObject(BackDC, BackInfo.hbmColor);
   DrawIconEx(BackDC, 0,0,FrontIcon, 0,0,0,0,DI_NORMAL);
 
   Result := CreateIconIndirect(BackInfo);
 
   SelectObject(FrontDC, FrontSv);
   DeleteDC(FrontDC);
   SelectObject(BackDC, BackSv);
   DeleteDC(BackDC);
   ReleaseDC(0,WinDC);
   DeleteObject(FrontInfo.hbmColor);
   DeleteObject(FrontInfo.hbmMask);
   DeleteObject(BackInfo.hbmColor);
   DeleteObject(BackInfo.hbmMask);
 end;
 
 // Remember: The icon created with this function must be destroyed with 
// DestroyIcon() function when finished using it. 
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
