---
Title: Using Visual Basic arrays in Delphi
Date: 01.01.2007
---


Using Visual Basic arrays in Delphi
===================================

> How do I pass arrays from VB to Delphi?

Arrays can be passed as variants:

VB module code:

    Attribute VB_Name = "Module1"
    Declare Function TestMin Lib "c:\windows\system\NoelSArr"
       (Nums As Variant) As Integer

VB form code:

    Dim A As Variant
    Private Sub Command1_Click()
      A = Array(4, 3)
      MsgBox (TestMin(A))
    End Sub

Delphi DLL code:

    library NoelSArray;

    function TestMin(const Nums: Variant): integer; export; stdcall;
    var
     p1: Variant;
    begin
     p1 := VarArrayCreate([0, 1], VT_I4);
     p1:= Nums;
      if (p1[0] < p1[1]) then
       result:= p1[0]
     else
       Result:= p1[1];
    end;
