---
Title: Stack Overflow, runtime error 202
Date: 01.01.2007
---


Stack Overflow, runtime error 202
=================================

Simply put, stack overflows are caused by putting too much on the stack.
Usually, they are caused by recursive procedures that never end. A good
example would be creating an event handler for the TMemo\'s onChange
event, and making a change to the Memo during the processing of the
event. Every time the OnChange event gets fired, another change is made,
so the OnChange event gets fired again in an almost endless loop. The
loop finally ends when the stack overflows, and the application crashes.

Here is an example of a recursive procedure:

    procedure RecursiveBlowTheStack;
    begin
      RecursiveBlowTheStack;
    end;

Sometimes, a stack overflow is caused by too many large procedures. Each
procedure calls another procedure, until the stack simply overflows.
This can be remidied by breaking up large procedures into smaller ones.
A good rule of thumb in regard to a procedures size is if the
procedure\'s source code takes up more than a screen, its time to break
it down into smaller procedures.

Finally, stack overflows can be caused by creating very large local
variables inside a procedure, or passing a large variable by value to
another procedure. Consider the passing of string variables. If the
string is 255 characters (plus the length byte), if passed by value, you
are actually taking up 256 bytes off the stack. If the procedure

you are calling passes the string by value to yet another procedure, the
string now takes 512 bytes of stack space. Passing the string (or other
variable) as a var or const parameter takes only 4 bytes, since var and
const parameters are simply pointers to the actual data. You can also
create large variables on the heap by dynamic allocation of the memory;

The following code demonstrates two procedures BlowTheStack(), and
NoBlowTheStack(). The BlowTheStack procedure attempts to allocate a
large local variable designed to be large enough to crash the

application. The NoBlowTheStack() procedure allocates the same large
variable but allocates it on the heap so the function will succeed.

    type
      PBigArray = ^TBigArray;
    {$IFDEF WIN32}
      TBigArray = array[0..10000000] of byte;
    {$ELSE}
      TBigArray = array[0..64000] of byte;
    {$ENDIF}
     
    procedure BlowTheStack;
    var
      BigArray : TBigArray;
    begin
      BigArray[0] := 10;
    end;
     
    procedure NoBlowTheStack;
    var
      BigArray : PBigArray;
    begin
      GetMem(BigArray, sizeof(BigArray^));
      BigArray^[0] := 10;
      FreeMem(BigArray, sizeof(BigArray^));
    end;

Finally, the following code demonstrates creating procedures that accept
large variables as parameters. The PassByValueAnCrash() procedure is
designed to crash since the value parameter is too large

for the stack. The PassByVar(), PassByPointer(), and PassByConst will
succeed, since these procedures only use 4 bytes of stack space. Note
that you cannot modify a parameter passed as const, as a const parameter
is assumed to be read only.

Example:

    procedure PassByValueAnCrash(BigArray : TBigArray);
    begin
      BigArray[0] := 10;
    end;
     
    procedure PassByVar(var BigArray : TBigArray);
    begin
      BigArray[0] := 10;
    end;
     
    procedure PassByPointer(BigArray : PBigArray);
    begin
      PBigArray^[0] := 10;
    end;
     
    procedure PassByConst(const BigArray : TBigArray);
    begin
      ShowMessage(IntToStr(BigArray[0]));
    end;
