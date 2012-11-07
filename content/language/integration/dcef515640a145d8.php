<h1>Соответствие типов С++ и Delphi</h1>
<div class="date">01.01.2007</div>


<p>C Data Type | Object Pascal |  Description</p>
<p>----------------------------------------------</p>
<p>LPSTR       PAnsiChar;  String &gt;pointer</p>
<p>LPCSTR      PAnsiChar;  String &gt;pointer</p>
<p>DWORD       Integer;    Whole numbers</p>
<p>BOOL        LongBool;   Boolean values</p>
<p>PBOOL       ^BOOL;      Pointer to a Boolean value</p>
<p>Pbyte       ^Byte;      Pointer to a byte value</p>
<p>PINT        ^Integer;   Pointer to an integer value</p>
<p>Psingle     ^Single;    Pointer to a single (floating point) value</p>
<p>PWORD       ^Word;      Pointer to a 16-bit value</p>
<p>PDWORD      ^DWORD;     Pointer to a 32-bit value</p>
<p>LPDWORD     PDWORD;     Pointer to a 32-bit value</p>
<p>UCHAR       Byte;       8-bit values (can represent characters)</p>
<p>PUCHAR      ^Byte;      Pointer to 8-bit values</p>
<p>SHORT       Smallint;   16-bit whole numbers</p>
<p>UINT        Integer;    32-bit whole numbers. Traditionally,</p>
<p>                        this was used to represent unsigned integers,</p>
<p>                        but Object Pascal does not have a true</p>
<p>                        unsigned integer data type.</p>
<p>PUINT       ^UINT;      Pointer to 32-bit whole numbers</p>
<p>ULONG       Longint;    32-bit whole numbers. Traditionally,</p>
<p>                        this was used to represent unsigned integers,</p>
<p>                        but Object Pascal does not have a true</p>
<p>                        unsigned integer data type.</p>
<p>PULONG      ^ULONG;     Pointer to 32-bit whole numbers</p>
<p>PLongint    ^Longint;   Pointer to 32-bit values</p>
<p>PInteger    ^Integer;   Pointer to 32-bit values</p>
<p>PSmallInt   ^Smallint;  Pointer to 16-bit values</p>
<p>PDouble     ^Double;    Pointer to double (floating point) values</p>
<p>LCID        DWORD;      A local identifier</p>
<p>LANGID      Word;       A language identifier</p>
<p>THandle     Integer;    An object handle. Many Windows API functions return a value</p>
<p>                        of type THandle, which identobject ifies that object within</p>
<p>                        Windows'internal object tracking tables.</p>
<p>PHandle     ^THandle;   A pointer to a handle</p>
<p>WPARAM      Longint;    A 32-bit message parameter. Under earlier versions of Windows,</p>
<p>                        this was a 16-bit data type.</p>
<p>LPARAM      Longint;    A 32-bit message parameter</p>
<p>LRESULT     Longint;    A 32-bit function return value</p>
<p>HWND        Integer;    A handle to a window. All windowed controls, child windows,</p>
<p>                        main windows, etc., have a corresponding window handle that</p>
<p>                        identifies them within Windows'internal tracking tables.</p>
<p>HHOOK       Integer;    A handle to an installed Windows system hook</p>
<p>ATOM        Word;       An index into the local or global atom table for a string</p>
<p>HGLOBAL     THandle;    A handle identifying a globally allocated dynamic memory object.</p>
<p>                        Under 32-bit Windows, there is no distinction between globally</p>
<p>                        and locally allocated memory.</p>
<p>HLOCAL      THandle;    A handle identifying a locally allocated dynamic memory object.</p>
<p>                        Under 32-bit Windows, there is no distinction between globally</p>
<p>                        and locally allocated memory.</p>
<p>FARPROC     Pointer;    A pointer to a procedure, usually used as a parameter type in</p>
<p>                        functions that require a callback function</p>
<p>HGDIOBJ     Integer;    A handle to a GDI object. Pens, device contexts, brushes, etc.,</p>
<p>                        all have a handle of this type that identifies them within</p>
<p>                        Windows'internal tracking tables.</p>
<p>HBITMAP     Integer;    A handle to a Windows bitmap object</p>
<p>HBRUSH      Integer;    A handle to a Windows brush object</p>
<p>HDC         Integer;    A handle to a device context</p>
<p>HENHMETAFILE  Integer;  A handle to a Windows enhanced metafile object</p>
<p>HFONT       Integer;    A handle to a Windows logical font object</p>
<p>HICON       Integer;    A handle to a Windows icon object</p>
<p>HMENU       Integer;    A handle to a Windows menu object</p>
<p>HMETAFILE   Integer;    A handle to a Windows metafile object</p>
<p>HINST       Integer;    A handle to an instance object</p>
<p>HMODULE     HINST;      A handle to a module</p>
<p>HPALETTE    Integer;    A handle to a Windows color palette</p>
<p>HPEN        Integer;    A handle to a Windows pen object</p>
<p>HRGN        Integer;    A handle to a Windows region object</p>
<p>HRSRC       Integer;    A handle to a Windows resource object</p>
<p>HKL         Integer;    A handle to a keyboard layout</p>
<p>HFILE       Integer;    A handle to an open file</p>
<p>HCURSOR     HICON;      A handle to a Windows mouse cursor object</p>
<p>COLORREF    DWORD;      A Windows color reference value, containing values</p>
<p>                        for the red, green, and of ;bsp;blue components of a color</p>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
