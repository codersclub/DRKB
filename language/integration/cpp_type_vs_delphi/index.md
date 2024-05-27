---
Title: Соответствие типов С++ и Delphi
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Соответствие типов С++ и Delphi
===============================

C Data Type | Object Pascal | Description
------------|---------------|-------------
LPSTR       |PAnsiChar;     |String \>pointer
LPCSTR      |PAnsiChar;     |String \>pointer
DWORD       |Integer;       |Whole numbers
BOOL        |LongBool;      |Boolean values
PBOOL       |^BOOL;         |Pointer to a Boolean value
Pbyte       |^Byte;         |Pointer to a byte value
PINT        |^Integer;      |Pointer to an integer value
Psingle     |^Single;       |Pointer to a single (floating point) value
PWORD       |^Word;         |Pointer to a 16-bit value
PDWORD      |^DWORD;        |Pointer to a 32-bit value
LPDWORD     |PDWORD;        |Pointer to a 32-bit value
UCHAR       |Byte;          |8-bit values (can represent characters)
PUCHAR      |^Byte;         |Pointer to 8-bit values
SHORT       |Smallint;      |16-bit whole numbers
UINT        |Integer;       |32-bit whole numbers. Traditionally, this was used to represent unsigned integers, but Object Pascal does not have a true unsigned integer data type.
PUINT       |^UINT;         |Pointer to 32-bit whole numbers
ULONG       |Longint;       |32-bit whole numbers. Traditionally, this was used to represent unsigned integers, but Object Pascal does not have a true unsigned integer data type.
PULONG      |^ULONG;        |Pointer to 32-bit whole numbers
PLongint    |^Longint;      |Pointer to 32-bit values
PInteger    |^Integer;      |Pointer to 32-bit values
PSmallInt   |^Smallint;     |Pointer to 16-bit values
PDouble     |^Double;       |Pointer to double (floating point) values
LCID        |DWORD;         |A local identifier
LANGID      |Word;          |A language identifier
THandle     |Integer;       |An object handle. Many Windows API functions return a value of type THandle, which identobject ifies that object within Windows\'internal object tracking tables.
PHandle     |^THandle;      |A pointer to a handle
WPARAM      |Longint;       |A 32-bit message parameter. Under earlier versions of Windows, this was a 16-bit data type.
LPARAM      |Longint;       |A 32-bit message parameter
LRESULT     |Longint;       |A 32-bit function return value
HWND        |Integer;       |A handle to a window. All windowed controls, child windows, main windows, etc., have a corresponding window handle that identifies them within Windows\'internal tracking tables.
HHOOK       |Integer;       |A handle to an installed Windows system hook
ATOM        |Word;          |An index into the local or global atom table for a string
HGLOBAL     |THandle;       |A handle identifying a globally allocated dynamic memory object. Under 32-bit Windows, there is no distinction between globally and locally allocated memory.
HLOCAL      |THandle;       |A handle identifying a locally allocated dynamic memory object. Under 32-bit Windows, there is no distinction between globally and locally allocated memory.
FARPROC     |Pointer;       |A pointer to a procedure, usually used as a parameter type in functions that require a callback function
HGDIOBJ     |Integer;       |A handle to a GDI object. Pens, device contexts, brushes, etc., all have a handle of this type that identifies them within Windows\'internal tracking tables.
HBITMAP     |Integer;       |A handle to a Windows bitmap object
HBRUSH      |Integer;       |A handle to a Windows brush object
HDC         |Integer;       |A handle to a device context
HENHMETAFILE | Integer;     |A handle to a Windows enhanced metafile object
HFONT       |Integer;       |A handle to a Windows logical font object
HICON       |Integer;       |A handle to a Windows icon object
HMENU       |Integer;       |A handle to a Windows menu object
HMETAFILE   |Integer;       |A handle to a Windows metafile object
HINST       |Integer;       |A handle to an instance object
HMODULE     |HINST;         |A handle to a module
HPALETTE    |Integer;       |A handle to a Windows color palette
HPEN        |Integer;       |A handle to a Windows pen object
HRGN        |Integer;       |A handle to a Windows region object
HRSRC       |Integer;       |A handle to a Windows resource object
HKL         |Integer;       |A handle to a keyboard layout
HFILE       |Integer;       |A handle to an open file
HCURSOR     |HICON;         |A handle to a Windows mouse cursor object
COLORREF    |DWORD;         |A Windows color reference value, containing values for the red, green, and of ;bsp;blue components of a color

