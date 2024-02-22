---
Title: Как работать с комплексными числами?
Date: 01.01.2000
Author: Ing.Büro R.Tschaggelar
Source: <https://www.ibrtses.com/delphi/complexrec.html>
ID: 04064
---


Как работать с комплексными числами?
====================================

Complex numbers

Complex numbers have two representations :

- rectanglar : Z = a + i * b, a being the real part, and b being the imaginary part
- polar : Z = r * exp(i * phi), r being the absolute value, and phi being the argument(angle)

a reason to demotivate compiler writers to have it as native type.

Here is a unit that approaches the complex as record.  
the used record is of dual use, either rectangular or polar,
one just has to keep in mind what in is at the moment.

    { unit for complex numbers based on C_reords
    -----------------------------------------
    they are efficient on arrays
    }
    unit ComplexRec;
     
    interface
     
    type
      float = extended;
     
      ComplexPtr = ^Complex;
      Complex = record // C_record without rectangular/polar discrimination
        a, b: float; // (re,im) or (abs,arg)
      end;
     
    function C_Copy(a: ComplexPtr): ComplexPtr; // result:=a
     
    function C_One: ComplexPtr; // result:=1 BOTH
    function C_I: ComplexPtr; // result:=i RECTANGULAR
    function C_IP: ComplexPtr; // result:=i POLAR
    procedure C_P2R(a: ComplexPtr); // polar to rectangular
    procedure C_R2P(a: ComplexPtr); // rectangular to polar
    function C_abs(a: ComplexPtr): float; // RECTANGULAR
    function C_arg(a: ComplexPtr): float; // RECTANGULAR
    function C_re(a: ComplexPtr): float; // POLAR
    function C_im(a: ComplexPtr): float; // POLAR
    procedure C_Inv(a: ComplexPtr); // a:=-a RECTANGULAR
    procedure C_InvP(a: ComplexPtr); // a:=-a POLAR
    procedure C_Conj(a: ComplexPtr); // a:=konjug(a) BOTH
    function C_ConjN(a: ComplexPtr): ComplexPtr; //result:=konjug(a) BOTH
    procedure C_Scale(a: ComplexPtr; u: float); // a:=a*u;
    procedure C_ScaleP(a: ComplexPtr; u: float); // a:=a*u;
     
    procedure C_Add(a, b: ComplexPtr); //a:=a+b RECTANGULAR
    function C_AddN(a, b: ComplexPtr): ComplexPtr; //result:=a+b RECTANGULAR
    procedure C_Sub(a, b: ComplexPtr); //a:=a-b RECTANGULAR
    function C_SubN(a, b: ComplexPtr): ComplexPtr; //result:=a-b RECTANGULAR
    procedure C_Mul(a, b: ComplexPtr); //a:=a*b RECTANGULAR
    function C_MulN(a, b: ComplexPtr): ComplexPtr; //result:=a*b RECTANGULAR
    procedure C_MulP(a, b: ComplexPtr); //a:=a*b POLAR
    function C_MulNP(a, b: ComplexPtr): ComplexPtr; //result:=a*b POLAR
    procedure C_DivP(a, b: ComplexPtr); //a:=a/b POLAR
    function C_DivNP(a, b: ComplexPtr): ComplexPtr; //result:=a/b POLAR
    procedure C_Div(a, b: ComplexPtr); //a:=a/b POLAR
    function C_DivN(a, b: ComplexPtr): ComplexPtr; //result:=a/b POLAR
    function C_ExpN(a: ComplexPtr): ComplexPtr; // RECTANGLE
    function C_LogN(a: ComplexPtr): ComplexPtr; // POLAR
    function C_SinN(a: ComplexPtr): ComplexPtr;
    function C_CosN(a: ComplexPtr): ComplexPtr;
    function C_TanN(a: ComplexPtr): ComplexPtr;
    function C_SinhN(a: ComplexPtr): ComplexPtr;
    function C_CoshN(a: ComplexPtr): ComplexPtr;
    function C_TanhN(a: ComplexPtr): ComplexPtr;
    function C_IntPowerN(a: ComplexPtr; n: integer): ComplexPtr; // RECTANGLE
    function C_IntPowerNP(a: ComplexPtr; n: integer): ComplexPtr; // POLAR
     
    function C_ParallelN(a, b: ComplexPtr): ComplexPtr; // result:=a//b =(a*b)/(a+b) RECTANGULAR
    // electronic parallel circuit
     
    implementation
     
    uses math;
     
    const AlmostZero = 1E-30; // test for zero
     
    function C_Copy(a: ComplexPtr): ComplexPtr; // result:=a
    begin
      result := new(ComplexPtr);
      result.a := a.a; result.b := a.b;
    end;
     
    function C_One: ComplexPtr; // result:=1
    begin
      result := new(ComplexPtr);
      result.a := 1; result.b := 0;
    end;
     
    function C_I: ComplexPtr; // result:=i RECTANGULAR
    begin
      result := new(ComplexPtr);
      result.a := 0; result.b := 1;
    end;
     
    function C_IP: ComplexPtr; // result:=i POLAR
    begin
      result := new(ComplexPtr);
      result.a := 1; result.b := pi / 2;
    end;
     
    procedure C_P2R(a: ComplexPtr);
    var t, u, v: float;
    begin
      t := a.a;
      sincos(a.b, u, v);
      a.a := t * v; a.b := t * u;
    end;
     
    procedure C_R2P(a: ComplexPtr);
    var t: float;
    begin
      t := a.a; a.a := sqrt(sqr(a.a) + sqr(a.b));
      if (abs(t)0 then a.b := pi / 2
      else
        a.b := -pi / 2;
    end
    else
      begin
        a.b := arctan(a.b / t);
        if (t < 0) then a.b := a.b + pi;
      end;
    end;
     
    function C_abs(a: ComplexPtr): float;
    begin
      result := sqrt(sqr(a.a) + sqr(a.b));
    end;
     
    function C_arg(a: ComplexPtr): float;
    begin
      if (abs(a.a)0 then result := pi / 2
    else
      result := -pi / 2;
    end
    else
      begin
        result := arctan(a.b / a.a);
        if (a.a < 0) then result := result + pi;
      end;
    end;
     
    function C_re(a: ComplexPtr): float; // POLAR
    begin
      result := a.a * cos(a.b);
    end;
     
    function C_im(a: ComplexPtr): float; // POLAR
    begin
      result := a.a * sin(a.b);
    end;
     
    procedure C_Inv(a: ComplexPtr); // a:=-a RECTANGULAR
    begin
      a.a := -a.a; a.b := -a.b;
    end;
     
    procedure C_InvP(a: ComplexPtr); // a:=-a POLAR
    begin
      a.b := a.b + pi;
    end;
     
    procedure C_Conj(a: ComplexPtr); // a:=konjug(a) BOTH
    begin
      a.b := -a.b;
    end;
     
    function C_ConjN(a: ComplexPtr): ComplexPtr; //result:=konjug(a) BOTH
    begin
      result := new(ComplexPtr);
      result.a := a.a;
      result.b := -a.b;
    end;
     
    procedure C_Scale(a: ComplexPtr; u: float); // a:=a*u;
    begin
      a.a := a.a * u;
      a.b := a.b * u;
    end;
     
    procedure C_ScaleP(a: ComplexPtr; u: float); // a:=a*u;
    begin
      a.a := a.a * u;
    end;
     
    procedure C_Add(a, b: ComplexPtr); //a:=a+b RECTANGULAR
    begin
      a.a := a.a + b.a;
      a.b := a.b + b.b;
    end;
     
    function C_AddN(a, b: ComplexPtr): ComplexPtr; //result:=a+b RECTANGULAR
    begin
      result := new(ComplexPtr);
      result.a := a.a + b.a;
      result.b := a.b + b.b;
    end;
     
    procedure C_Sub(a, b: ComplexPtr); //a:=a-b RECTANGULAR
    begin
      a.a := a.a - b.a;
      a.b := a.b - b.b;
    end;
     
    function C_SubN(a, b: ComplexPtr): ComplexPtr; //result:=a-b RECTANGULAR
    begin
      result := new(ComplexPtr);
      result.a := a.a - b.a;
      result.b := a.b - b.b;
    end;
     
    procedure C_Mul(a, b: ComplexPtr); //a:=a*b RECTANGULAR
    var u, v: float;
    begin
      u := a.a * b.a - a.b * b.b;
      v := a.a * b.b + a.b * b.a;
      a.a := u;
      a.b := v;
    end;
     
    function C_MulN(a, b: ComplexPtr): ComplexPtr; //result:=a*b RECTANGULAR
    begin
      result := new(ComplexPtr);
      result.a := a.a * b.a - a.b * b.b;
      result.b := a.a * b.b + a.b * b.a;
    end;
     
    procedure C_MulP(a, b: ComplexPtr); //a:=a*b POLAR
    begin
      a.a := a.a * b.a;
      a.b := a.b + b.b;
    end;
     
    function C_MulNP(a, b: ComplexPtr): ComplexPtr; //result:=a*b POLAR
    begin
      result := new(ComplexPtr);
      result.a := a.a * b.a;
      result.b := a.b + b.b;
    end;
     
    procedure C_Div(a, b: ComplexPtr); //a:=a/b RECTANGULAR
    var t: float;
    begin
      t := a.a / b.a + a.b / b.b;
      a.b := -a.a / b.b + a.b / b.a;
      a.a := t;
    end;
     
    function C_DivN(a, b: ComplexPtr): ComplexPtr; //result:=a/b RECTANGULAR
    begin
      result := new(ComplexPtr);
      result.a := a.a / b.a + a.b / b.b;
      result.b := -a.a / b.b + a.b / b.a;
    end;
     
    procedure C_DivP(a, b: ComplexPtr); //a:=a/b POLAR
    begin
      a.a := a.a / b.a;
      a.b := a.b - b.b;
    end;
     
    function C_DivNP(a, b: ComplexPtr): ComplexPtr; //result:=a/b POLAR
    begin
      result := new(ComplexPtr);
      result.a := a.a / b.a;
      result.b := a.b - b.b;
    end;
     
    function C_ExpN(a: ComplexPtr): ComplexPtr; // RECTANGLE
    begin
      result := new(ComplexPtr);
      result.a := exp(a.a);
      result.b := a.b;
      C_P2R(result);
    end;
     
    function C_LogN(a: ComplexPtr): ComplexPtr; // POLAR
    begin
      result := new(ComplexPtr);
      result.a := ln(a.a);
      result.b := a.b;
      C_R2P(result);
    end;
     
    function C_SinN(a: ComplexPtr): ComplexPtr;
    var z, n, v, t: ComplexPtr;
    begin
      t := C_I;
      v := C_MulN(a, t); // i*a
      z := C_expN(a); // exp(i*a)
      t := C_Copy(v);
      C_Inv(t); // -i*a
      t := C_ExpN(v); // exp(-i*a)
      C_Sub(z, t);
      n := C_I;
      C_Scale(n, 2);
      result := C_DivN(z, n);
      dispose(z); dispose(n); dispose(v); dispose(t);
    end;
     
    function C_CosN(a: ComplexPtr): ComplexPtr;
    var z, n, v, t: ComplexPtr;
    begin
      t := C_I;
      v := C_MulN(a, t); // i*a
      z := C_expN(a); // exp(i*a)
      t := C_Copy(v);
      C_Inv(t); // -i*a
      t := C_ExpN(v); // exp(-i*a)
      C_Add(z, t);
      n := C_One;
      C_Scale(n, 2);
      result := C_DivN(z, n);
      dispose(z); dispose(n); dispose(v); dispose(t);
    end;
     
    function C_TanN(a: ComplexPtr): ComplexPtr;
    begin
     
    end;
     
    function C_SinhN(a: ComplexPtr): ComplexPtr;
    var u, v, t: ComplexPtr;
    begin
      u := C_ExpN(a);
      t := C_Copy(a);
      C_inv(t);
      v := C_ExpN(t);
      result := C_SubN(u, v);
      C_Scale(result, 1 / 2);
      dispose(u);
      dispose(v);
      dispose(t);
    end;
     
    function C_CoshN(a: ComplexPtr): ComplexPtr;
    var u, v, t: ComplexPtr;
    begin
      u := C_ExpN(a);
      t := C_Copy(a);
      C_inv(t);
      v := C_ExpN(t);
      result := C_AddN(u, v);
      C_Scale(result, 1 / 2);
      dispose(u);
      dispose(v);
      dispose(t);
    end;
     
    function C_TanhN(a: ComplexPtr): ComplexPtr;
    begin
     
    end;
     
    function C_IntPowerN(a: ComplexPtr; n: integer): ComplexPtr;
    var j: integer;
      u, v: float;
    begin
      if n = 0 then
        result := C_One
      else
        begin
          result := C_Copy(a);
          if n > 1 then
            begin
              C_R2P(result);
              u := result.a; v := result.b;
              for j := 2 to n do
                begin
                  u := u * result.a; v := v + result.b;
                end;
              result.a := u; result.b := v;
              C_P2R(result);
            end;
          if n < 0 then
            begin
     
            end;
        end;
    end;
     
    function C_IntPowerNP(a: ComplexPtr; n: integer): ComplexPtr;
    var j: integer;
      u, v: float;
    begin
      result := C_Copy(a);
      u := result.a; v := result.b;
      for j := 2 to n do
        begin
          u := u * result.a; v := v + result.b;
        end;
      result.a := u; result.b := v;
    end;
     
    function C_ParallelN(a, b: ComplexPtr): ComplexPtr; // result:=a//b = (a*b)/(a+b)
    var z, n: ComplexPtr;
    begin
      z := C_MulN(a, b);
      n := C_AddN(a, b);
      C_R2P(n);
      C_R2P(z);
      result := C_DivNP(z, n);
      C_P2R(result);
      dispose(n);
      dispose(z);
    end;
     
    end.

Copyright (99,2000) Ing.Büro R.Tschaggelar
