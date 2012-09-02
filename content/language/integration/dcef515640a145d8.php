<h1>Соответствие типов С++ и Delphi</h1>
<div class="date">01.01.2007</div>


<p>C Data Type | Object Pascal |&nbsp; Description </p>
<p>----------------------------------------------</p>
<p>LPSTR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PAnsiChar;&nbsp; String &gt;pointer </p>
<p>LPCSTR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PAnsiChar;&nbsp; String &gt;pointer </p>
<p>DWORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; Whole numbers </p>
<p>BOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LongBool;&nbsp;&nbsp; Boolean values </p>
<p>PBOOL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^BOOL;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to a Boolean value </p>
<p>Pbyte&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^Byte;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to a byte value </p>
<p>PINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^Integer;&nbsp;&nbsp; Pointer to an integer value </p>
<p>Psingle&nbsp;&nbsp;&nbsp;&nbsp; ^Single;&nbsp;&nbsp;&nbsp; Pointer to a single (floating point) value </p>
<p>PWORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^Word;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to a 16-bit value </p>
<p>PDWORD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^DWORD;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to a 32-bit value </p>
<p>LPDWORD&nbsp;&nbsp;&nbsp;&nbsp; PDWORD;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to a 32-bit value </p>
<p>UCHAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Byte;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8-bit values (can represent characters) </p>
<p>PUCHAR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^Byte;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to 8-bit values </p>
<p>SHORT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Smallint;&nbsp;&nbsp; 16-bit whole numbers </p>
<p>UINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; 32-bit whole numbers. Traditionally, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; this was used to represent unsigned integers, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; but Object Pascal does not have a true </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; unsigned integer data type. </p>
<p>PUINT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^UINT;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to 32-bit whole numbers </p>
<p>ULONG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Longint;&nbsp;&nbsp;&nbsp; 32-bit whole numbers. Traditionally, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; this was used to represent unsigned integers, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; but Object Pascal does not have a true </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; unsigned integer data type. </p>
<p>PULONG&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ^ULONG;&nbsp;&nbsp;&nbsp;&nbsp; Pointer to 32-bit whole numbers </p>
<p>PLongint&nbsp;&nbsp;&nbsp; ^Longint;&nbsp;&nbsp; Pointer to 32-bit values </p>
<p>PInteger&nbsp;&nbsp;&nbsp; ^Integer;&nbsp;&nbsp; Pointer to 32-bit values </p>
<p>PSmallInt&nbsp;&nbsp; ^Smallint;&nbsp; Pointer to 16-bit values </p>
<p>PDouble&nbsp;&nbsp;&nbsp;&nbsp; ^Double;&nbsp;&nbsp;&nbsp; Pointer to double (floating point) values </p>
<p>LCID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DWORD;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A local identifier </p>
<p>LANGID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Word;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A language identifier </p>
<p>THandle&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; An object handle. Many Windows API functions return a value </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; of type THandle, which identobject ifies that object within </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Windows'internal object tracking tables. </p>
<p>PHandle&nbsp;&nbsp;&nbsp;&nbsp; ^THandle;&nbsp;&nbsp; A pointer to a handle </p>
<p>WPARAM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Longint;&nbsp;&nbsp;&nbsp; A 32-bit message parameter. Under earlier versions of Windows, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; this was a 16-bit data type. </p>
<p>LPARAM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Longint;&nbsp;&nbsp;&nbsp; A 32-bit message parameter </p>
<p>LRESULT&nbsp;&nbsp;&nbsp;&nbsp; Longint;&nbsp;&nbsp;&nbsp; A 32-bit function return value </p>
<p>HWND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a window. All windowed controls, child windows, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; main windows, etc., have a corresponding window handle that </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; identifies them within Windows'internal tracking tables. </p>
<p>HHOOK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to an installed Windows system hook </p>
<p>ATOM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Word;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; An index into the local or global atom table for a string </p>
<p>HGLOBAL&nbsp;&nbsp;&nbsp;&nbsp; THandle;&nbsp;&nbsp;&nbsp; A handle identifying a globally allocated dynamic memory object. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Under 32-bit Windows, there is no distinction between globally </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and locally allocated memory. </p>
<p>HLOCAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; THandle;&nbsp;&nbsp;&nbsp; A handle identifying a locally allocated dynamic memory object. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Under 32-bit Windows, there is no distinction between globally </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and locally allocated memory. </p>
<p>FARPROC&nbsp;&nbsp;&nbsp;&nbsp; Pointer;&nbsp;&nbsp;&nbsp; A pointer to a procedure, usually used as a parameter type in </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; functions that require a callback function </p>
<p>HGDIOBJ&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a GDI object. Pens, device contexts, brushes, etc., </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; all have a handle of this type that identifies them within </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Windows'internal tracking tables. </p>
<p>HBITMAP&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows bitmap object </p>
<p>HBRUSH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows brush object </p>
<p>HDC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a device context </p>
<p>HENHMETAFILE&nbsp; Integer;&nbsp; A handle to a Windows enhanced metafile object </p>
<p>HFONT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows logical font object </p>
<p>HICON&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows icon object </p>
<p>HMENU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows menu object </p>
<p>HMETAFILE&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows metafile object </p>
<p>HINST&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to an instance object </p>
<p>HMODULE&nbsp;&nbsp;&nbsp;&nbsp; HINST;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A handle to a module </p>
<p>HPALETTE&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows color palette </p>
<p>HPEN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows pen object </p>
<p>HRGN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows region object </p>
<p>HRSRC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a Windows resource object </p>
<p>HKL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to a keyboard layout </p>
<p>HFILE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Integer;&nbsp;&nbsp;&nbsp; A handle to an open file </p>
<p>HCURSOR&nbsp;&nbsp;&nbsp;&nbsp; HICON;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A handle to a Windows mouse cursor object </p>
<p>COLORREF&nbsp;&nbsp;&nbsp; DWORD;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; A Windows color reference value, containing values </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; for the red, green, and of ;bsp;blue components of a color </p>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
