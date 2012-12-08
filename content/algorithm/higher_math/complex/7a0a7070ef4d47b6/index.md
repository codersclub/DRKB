---
Title: Модуль для работы с комплексными числами
Date: 01.01.2007
---


Модуль для работы с комплексными числами
========================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Модуль для работы с комплексными числами
     
    Модуль предназначен для работы с комплексными числами.
    Данный модуль был взят с http://gaivan.hypermart.net и переработан мной
     
    Зависимости: SysUtils - для работы ComplexToStr и StrToComplex; Math - для cmPow
    Автор:       Separator, wilhelm@mail.ru, ICQ:162770303, Алматы
    Copyright:   http://gaivan.hypermart.net
    Дата:        16 марта 2004 г.
    ********************************************** }
     
    unit cmplx;
    //----------------------------------------------------------------------------//
    // Complex numbers routines library //
    // Copyright (c) 2001 by Serghei Gaivan //
    // e-mail: gaivan@mail.hypermart.net //
    // http://gaivan.hypermart.net //
    //----------------------------------------------------------------------------//
    // Update: //
    // 04.07.2003 Sergey Vilgelm (wilhelm@mail.kz) //
    //----------------------------------------------------------------------------//
     
    interface
     
    uses SysUtils, Math;
     
    type
        TComplexType = extended;
     
        PComplex = ^TComplex;
        TComplex = packed record
            x: TComplexType;
            y: TComplexType;
        end;
     
    const
        OneComplex : TComplex = (x: 1; y: 0);
        NegOneComplex : TComplex = (x: -1; y: 0);
        OneComplexIm : TComplex = (x: 0; y: 1);
        NegOneComplexIm : TComplex = (x: 0; y: -1);
        NullComplex : TComplex = (x: 0; y: 0);
        OneOneComplex : TComplex = (x: 1; y: 1);
        NegOneOneComplex : TComplex = (x: -1; y: 1);
        OneNegOneComplex : TComplex = (x: 1; y: -1);
        NegOneNegOneComplex : TComplex = (x: -1; y: -1);
     
    function Re(z: TComplex): TComplexType; // z :--> Re(z)
    function Im(z: TComplex): TComplexType; // z :--> Im(z)
     
    //------ Unary operations ----------------------------------------------------//
    function cConj(z: TComplex): TComplex; // z :--> z*
    function cNeg(z: TComplex): TComplex; // z :--> -z
    function cFlip(z: TComplex): TComplex; // (x, y) :--> (y, x)
    function cRCW(z: TComplex): TComplex; // (x, y) :--> (-y, x)
    function cRCC(z: TComplex): TComplex; // (x, y) :--> (y, -x)
     
    //------ Binary operations ---------------------------------------------------//
    function cSum(z1, z2: TComplex): TComplex; // z1, z2 :--> z1 + z2
    function cSub(z1, z2: TComplex): TComplex; // z1, z2 :--> z1 - z2
    function cMul(z1, z2: TComplex): TComplex; // z1, z2 :--> z1 * z2
    function cDiv(z1, z2: TComplex): TComplex; // z1, z2 :--> z1 / z2
     
    //------ Standard routines ---------------------------------------------------//
    function cPolar(rho, phi: TComplexType): TComplex; // (rho, phi) :--> z
    function cAbs(z: TComplex): TComplexType; // z :--> |z|
    function cArg(z: TComplex): TComplexType; // z :--> arg(z)
    function cNorm(z: TComplex): TComplexType; // z :--> |z|^2
     
    //------ Algebraic functions -------------------------------------------------//
    function cSqr(z: TComplex): TComplex; // z :--> z^2
    function cInv(z: TComplex): TComplex; // z :--> 1 / z
    function cSqrt(z: TComplex): TComplex; // z :--> Sqrt(z)
    function cPow(z: TComplex; n: integer): TComplex; // z :--> z^n
     
    //------ Transcendent functions ----------------------------------------------//
    function cLn(z: TComplex): TComplex; // z :--> Ln(z)
    function cExp(z: TComplex): TComplex; // z :--> Exp(z)
     
    //------ Trigonometric functions ---------------------------------------------//
    function cSin(z: TComplex): TComplex; // z :--> Sin(z)
    function cCos(z: TComplex): TComplex; // z :--> Cos(z)
    function cTan(z: TComplex): TComplex; // z :--> Tan(z)
    function cCotan(z: TComplex): TComplex; // z :--> Cotan(z)
     
    //------ Hyperbolic functions ------------------------------------------------//
    function cSinh(z: TComplex): TComplex; // z :--> Sinh(z)
    function cCosh(z: TComplex): TComplex; // z :--> Cosh(z)
    function cTanh(z: TComplex): TComplex; // z :--> Tanh(z)
    function cCotanh(z: TComplex): TComplex; // z :--> Cotanh(z)
     
    //------ Other operations ----- Sergey Vilgelm -------------------------------//
    function Complex(x, y: TComplexType): TComplex; // Result.x:= x; Result.y:= y
     
    function cEqual(z1, z2: TComplex): boolean; // z1 = z2
    function cEqualZero(z: TComplex): boolean; // z.x = 0 and z.y = 0
    function cEqualOne(z: TComplex): boolean; // z.x = 1 and z.y = 0
     
    function cmPow(z: TComplex; n: integer): TComplex; // Альтернативное возведение в степень, так как оригинальный cPow не корректно работает
     
    //------ String operations ---- Sergey Vilgelm -------------------------------//
    function ComplexToStr(z: TComplex): string;
    function StrToComplex(S: string): TComplex;
     
    implementation
     
    //----------------------------------------------------------------------------//
     
    function Re(z: TComplex): TComplexType; register;
    // z :--> Re(z)
    asm
             FLD TComplex.x [EAX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function Im(z: TComplex): TComplexType; register;
    // z :--> Im(z)
    asm
             FLD TComplex.y [EAX]
    end;
     
    //----------------------------------------------------------------------------//
    //------ Unary operations ----------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cConj(z: TComplex): TComplex; register;
    // z :--> z*
    asm
             FLD TComplex.y [EAX]
             FCHS
             FSTP TComplex.y [EDX]
             FLD TComplex.x [EAX]
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cNeg(z: TComplex): TComplex; register;
    // (x, y) :--> (-x, -y)
    asm
             FLD TComplex.x [EAX]
             FCHS
             FSTP TComplex.x [EDX]
             FLD TComplex.y [EAX]
             FCHS
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cFlip(z: TComplex): TComplex;
    // (x, y) :--> (y, x)
    asm
             FLD TComplex.y [EAX]
             FSTP TComplex.x [EDX]
             FLD TComplex.x [EAX]
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cRCW(z: TComplex): TComplex; register;
    // (x, y) :--> (-y, x) that is z :--> i * z
    asm
             FLD TComplex.y [EAX]
             FCHS
             FSTP TComplex.x [EDX]
             FLD TComplex.x [EAX]
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cRCC(z: TComplex): TComplex; register;
    // (x, y) :--> (y, -x)
    asm
             FLD TComplex.y [EAX]
             FSTP TComplex.x [EDX]
             FLD TComplex.x [EAX]
             FCHS
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
    //------ Binary operations ---------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cSum(z1, z2: TComplex): TComplex; register;
    // z1, z2 :--> z1 + z2
    asm
             FLD TComplex.x [EAX]
             FLD TComplex.x [EDX]
             FADD
             FSTP TComplex.x [ECX]
             FLD TComplex.y [EAX]
             FLD TComplex.y [EDX]
             FADD
             FSTP TComplex.y [ECX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cSub(z1, z2: TComplex): TComplex; register;
    // z1, z2 :--> z1 - z2
    asm
             FLD TComplex.x [EAX]
             FLD TComplex.x [EDX]
             FSUB
             FSTP TComplex.x [ECX]
             FLD TComplex.y [EAX]
             FLD TComplex.y [EDX]
             FSUB
             FSTP TComplex.y [ECX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cMul(z1, z2: TComplex): TComplex; register;
    // z1, z2 :--> z1 * z2
    asm
             FLD TComplex.x [EAX]
             FLD TComplex.x [EDX]
             FLD ST // x2 x2 x1
             FMUL ST, ST(2) // x1*x2 x2 x1
             FLD TComplex.y [EAX]
             FXCH ST(1) // x1*x2 y1 x2 x1
             FLD TComplex.y [EDX]
             FXCH ST(1)
             FLD ST(1)
             FMUL ST, ST(3)
             FSUB
             FSTP TComplex.x [ECX] // y2 y1 x2 x1
             FMULP ST(3), ST(0) //y1 x2 x1*y2
             FMUL // x2*y1 x1*y2
             FADD
             FSTP TComplex.y [ECX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cDiv(z1, z2: TComplex): TComplex; register;
    // z1, z2 :--> z1 / z2
    asm
             FLD TComplex.y [EDX]
             FLD ST(0)
             FMUL ST, ST
             FLD TComplex.x [EDX]
             FXCH ST(1)
             FLD ST(1)
             FMUL ST, ST
             FADD
             FLD1
             FDIVR
             FLD TComplex.x [EAX]
             FLD TComplex.y [EAX]
             FXCH ST(2)
             FLD ST(1)
             FMUL ST, ST(4)
             FLD ST(3)
             FMUL ST, ST(6)
             FADD
             FMUL ST, ST(1)
             FSTP TComplex.x [ECX]
             FXCH ST(4)
             FMUL
             FXCH ST(2)
             FMUL // x2*y1 x1*y2 1/norm
             FSUBR
             FMUL
             FSTP TComplex.y [ECX]
    end;
     
    //----------------------------------------------------------------------------//
    //------ Standard routines ---------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cPolar(rho, phi: TComplexType): TComplex; register;
    // (rho, phi) :--> z
    asm
             FLD rho
             FLD phi
             FSINCOS
             FMUL ST, ST(2)
             FSTP TComplex.x [EAX]
             FMUL
             FSTP TComplex.y [EAX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cAbs(z: TComplex): TComplexType; register;
    // z :--> |z|
    asm
             FLD TComplex.y [EAX]
             FMUL ST, ST
             FLD TComplex.x [EAX]
             FMUL ST, ST
             FADD
             FSQRT
    end;
     
    //----------------------------------------------------------------------------//
     
    function cArg(z: TComplex): TComplexType; register;
    // z :--> arg(z)
    asm
             FLD TComplex.y [EAX]
             FLD TComplex.x [EAX]
             FPATAN
    end;
     
    //----------------------------------------------------------------------------//
     
    function cNorm(z: TComplex): TComplexType; register;
    // z :--> |z|^2
    asm
             FLD TComplex.y [EAX]
             FMUL ST, ST
             FLD TComplex.x [EAX]
             FMUL ST, ST
             FADD
    end;
     
    //----------------------------------------------------------------------------//
    //------ Algebraic functions -------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cSqr(z: TComplex): TComplex; register;
    // z :--> z^2
    asm
             FLD TComplex.y [EAX]
             FLD ST
             FMUL ST, ST
             FLD TComplex.x [EAX]
             FLD ST
             FMUL ST, ST
             FXCH ST(3)
             FMUL
             FADD ST, ST
             FSTP TComplex.y [EDX]
             FSUB
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cSqrt(z: TComplex): TComplex; register;
    // z :--> sqrt(z)
    asm
             FLD TComplex.x [EAX]
             FLD ST
             FMUL ST, ST
             FLD TComplex.y [EAX]
             FMUL ST, ST
             FADD
             FSQRT
             FLD ST(1)
             FADD ST, ST(1)
             FABS
             FLD1
             FADD ST, ST
             FDIV
             FSQRT
             FSTP TComplex.x [EDX]
             FSUB
             FABS
             FLD1
             FADD ST, ST
             FDIV
             FSQRT
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cInv(z: TComplex): TComplex; register;
    // z :--> 1/z
    asm
             FLD TComplex.y [EAX]
             FLD ST
             FMUL ST, ST
             FLD TComplex.x [EAX]
             FXCH
             FLD ST(1)
             FMUL ST, ST
             FADD
             FLD1
             FDIVR
             FXCH ST(2)
             FMUL ST, ST(2)
             FSTP TComplex.y [EDX]
             FMUL
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cPow(z: TComplex; n: integer): TComplex; register;
    // z :--> z^n
    asm
             FLD TComplex.x [EAX]
             FLD TComplex.y [EAX]
             FLD1
             FLD ST(2)
             FMUL ST, ST
             FLD ST(2)
             FMUL ST, ST
             FADD
             FSQRT
             MOV EAX,EDX
             JMP @2
      @1: FMUL ST, ST
      @2: SHR EAX,1
             JNC @1
             FMUL ST(1),ST
             JNZ @1
             FSTP ST(0)
             FXCH ST(2)
             FPATAN
             MOV [ESP-$04],EDX
             FILD DWORD PTR [ESP-$04]
             FMUL
             FSINCOS
             FMUL ST,ST(2)
             FSTP TComplex.x [ECX]
             FMUL
             FSTP TComplex.y [ECX]
    end;
     
    //----------------------------------------------------------------------------//
    //------- Transcendent functions ---------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cLn(z: TComplex): TComplex; register;
    // z :--> Ln(z)
    asm
             FLD TComplex.y [EAX]
             FLD TComplex.x [EAX]
             FLDLN2
             FLD1
             FADD ST, ST
             FDIV
             FLD ST(2)
             FMUL ST, ST
             FLD ST(2)
             FMUL ST, ST
             FADD
             FYL2X
             FSTP TComplex.x [EDX]
             FPATAN
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cExp(z: TComplex): TComplex; register;
    // z :--> Exp(z)
    asm
             FLD TComplex.x [EAX]
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1)
             FLD TComplex.y [EAX]
             FSINCOS
             FMUL ST,ST(2)
             FSTP TComplex.x [EDX]
             FMUL
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
    //------ Trigonometric functions ---------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cSin(z: TComplex): TComplex; register;
    // z :--> Sin(z)
    asm
             FLD TComplex.y [EAX]
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1)
             FLD1
             FLD ST(1)
             FADD ST, ST
             FDIV
             FXCH
             FLD1
             FADD ST, ST
             FDIV
             FLD TComplex.x [EAX]
             FSINCOS
             FLD ST(2)
             FSUB ST, ST(4)
             FMUL
             FSTP TComplex.y [EDX]
             FXCH ST(2)
             FADD
             FMUL
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cCos(z: TComplex): TComplex; register;
    // z :--> Cos(z)
    asm
             FLD TComplex.y [EAX]
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1)
             FLD1
             FLD ST(1)
             FADD ST, ST
             FDIV
             FXCH
             FLD1
             FADD ST, ST
             FDIV
             FLD TComplex.x [EAX]
             FSINCOS
             FLD ST(2)
             FADD ST, ST(4)
             FMUL
             FSTP TComplex.x [EDX]
             FXCH ST(2)
             FSUBR
             FMUL
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cTan(z: TComplex): TComplex; register;
    // z :--> Tan(z)
    asm
             FLD TComplex.x [EAX]
             FADD ST, ST
             FLD TComplex.y [EAX]
             FADD ST, ST // 2y 2x
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1) // exp(2y) 2x
             FLD1 // 1 exp(2y) 2x
             FDIV ST(0), ST(1) // exp(-2y) exp(2y) 2x
             FLD1
             FADD ST, ST // 2 exp(-2y) exp(2y) 2x
             FLD ST(0) // 2 2 exp(-2y) exp(2y) 2x
             FDIVP ST(2), ST(0) // 2 exp(-2y)/2 exp(2y) 2x
             FDIVP ST(2), ST(0) // exp(-2y)/2 exp(2y)/2 2x
             FLD ST(1) // exp(2y)/2 exp(-2y)/2 exp(2y)/2 2x
             FSUB ST(0), ST(1) // sinh(2y) exp(-2y)/2 exp(2y)/2 2x
             FXCH ST(2) // exp(2y)/2 exp(-2y)/2 sinh(2y) 2x
             FADD // cosh(2y) sinh(2y) 2x
             FXCH ST(2) // 2x sinh(2y) cosh(2y)
             FSINCOS // cos(2x) sin(2x) sinh(2y) cosh(2y)
             FADDP ST(3), ST(0) // sin(2x) sinh(2y) (cos+cosh)
             FDIV ST(0), ST(2)
             FSTP TComplex.x [EDX] // sinh(2y) (cos+cosh)
             FDIVR
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cCotan(z: TComplex): TComplex; register;
    // z :--> Cotan(z)
    asm
             FLD TComplex.x [EAX]
             FADD ST, ST
             FLD TComplex.y [EAX]
             FADD ST, ST // 2y 2x
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1) // exp(2y) 2x
             FLD1 // 1 exp(2y) 2x
             FDIV ST(0), ST(1) // exp(-2y) exp(2y) 2x
             FLD1
             FADD ST, ST // 2 exp(-2y) exp(2y) 2x
             FLD ST(0) // 2 2 exp(-2y) exp(2y) 2x
             FDIVP ST(2), ST(0) // 2 exp(-2y)/2 exp(2y) 2x
             FDIVP ST(2), ST(0) // exp(-2y)/2 exp(2y)/2 2x
             FLD ST(0) // exp(-2y)/2 exp(-2y)/2 exp(2y)/2 2x
             FSUB ST(0), ST(2) // -sinh(2y) exp(-2y)/2 exp(2y)/2 2x
             FXCH ST(2)
             FADD
             FXCH ST(2)
             FSINCOS
             FSUBP ST(3), ST(0)
             FDIV ST(0), ST(2)
             FSTP TComplex.x [EDX]
             FDIVR
             FSTP TComplex.y [EDX]
    end;
     
     
    //----------------------------------------------------------------------------//
    //------ Hyperbolic functions -----------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function cSinh(z: TComplex): TComplex; register;
    // z :--> Sinh(z)
    asm
             FLD TComplex.x [EAX]
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1) // exp(x)
             FLD1 // 1 exp(x)
             FLD ST(1) // exp(x) 1 exp(x)
             FADD ST, ST // 2exp(x) 1 exp(x)
             FDIV // 1/2exp(x) exp(x)
             FXCH // exp(x) 1/2exp(x)
             FLD1 // 1 exp(x) 1/2exp(x)
             FADD ST, ST // 2 exp(x) 1/2exp(x)
             FDIV // exp(x)/2 1/2exp(x)
             FLD TComplex.y [EAX] // y tmp tmp2
             FSINCOS // cos(y) sin(y) tmp tmp2
             FLD ST(2) // tmp cos(y) sin(y) tmp tmp2
             FSUB ST, ST(4) // (tmp-tmp2) cos(y) sin(y) tmp tmp2
             FMUL
             FSTP TComplex.x [EDX] // sin(y) tmp tmp2
             FXCH ST(2) // tmp2 tmp sin(y)
             FADD // (tmp+tmp2 sin(y)
             FMUL
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cCosh(z: TComplex): TComplex; register;
    // z :--> Cosh(z)
    asm
             FLD TComplex.x [EAX]
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1) // exp(x)
             FLD1 // 1 exp(x)
             FLD ST(1) // exp(x) 1 exp(x)
             FADD ST, ST // 2exp(x) 1 exp(x)
             FDIV // 1/2exp(x) exp(x)
             FXCH // exp(x) 1/2exp(x)
             FLD1 // 1 exp(x) 1/2exp(x)
             FADD ST, ST // 2 exp(x) 1/2exp(x)
             FDIV // exp(x)/2 1/2exp(x)
             FLD TComplex.y [EAX] // y tmp tmp2
             FSINCOS // cos(y) sin(y) tmp tmp2
             FLD ST(2) // tmp cos(y) sin(y) tmp tmp2
             FADD ST, ST(4) // (tmp+tmp2) cos(y) sin(y) tmp tmp2
             FMUL
             FSTP TComplex.x [EDX] // sin(y) tmp tmp2
             FXCH ST(2) // tmp2 tmp sin(y)
             FSUB // (tmp-tmp2 sin(y)
             FMUL
             FSTP TComplex.y [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cTanh(z: TComplex): TComplex; register;
    // z :--> Tanh(z)
    asm
             FLD TComplex.y [EAX]
             FADD ST, ST
             FLD TComplex.x [EAX]
             FADD ST, ST // 2x 2y
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1) // exp(2x) 2y
             FLD1 // 1 exp(2x) 2y
             FDIV ST(0),ST(1) // exp(-2x) exp(2x) 2y
             FLD1
             FADD ST,ST // 2 exp(-2x) exp(2x) 2y
             FLD ST(0) // 2 2 exp(-2x) exp(2x) 2y
             FDIVP ST(2), ST(0) // 2 exp(-2x)/2 exp(2x) 2y
             FDIVP ST(2), ST(0) // exp(-2x)/2 exp(2x)/2 2y
             FLD ST(1) // exp(2x)/2 exp(-2x)/2 exp(2x)/2 2y
             FSUB ST(0), ST(1) // sinh(2x) exp(-2x)/2 exp(2x)/2 2y
             FXCH ST(2) // exp(2x)/2 exp(-2x)/2 sinh(2x) 2y
             FADD // cosh(2x) sinh(2x) 2y
             FXCH ST(2) // 2y sinh(2x) cosh(2x)
             FSINCOS // cos(2y) sin(2y) sinh(2x) cosh(2x)
             FADDP ST(3), ST(0) // sin(2y) sinh(2x) (cos+cosh)
             FDIV ST(0), ST(2)
             FSTP TComplex.y [EDX] // sinh(2x) (cos+cosh)
             FDIVR
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cCotanh(z: TComplex): TComplex; register;
    // z :--> Cotanh(z)
    asm
             FLD TComplex.y [EAX]
             FADD ST, ST
             FLD TComplex.x [EAX]
             FADD ST, ST
             FLDL2E
             FMUL
             FLD ST(0)
             FRNDINT
             FSUB ST(1), ST
             FXCH ST(1)
             F2XM1
             FLD1
             FADD
             FSCALE
             FSTP ST(1)
             FLD1
             FDIV ST(0), ST(1)
             FLD1
             FADD ST,ST
             FLD ST(0)
             FDIVP ST(2), ST(0)
             FDIVP ST(2), ST(0)
             FLD ST(0)
             FSUB ST(0), ST(2)
             FXCH ST(2)
             FADD
             FXCH ST(2)
             FSINCOS
             FSUBRP ST(3), ST(0)
             FDIV ST(0), ST(2)
             FSTP TComplex.y [EDX]
             FDIVR
             FSTP TComplex.x [EDX]
    end;
     
    //----------------------------------------------------------------------------//
    //------ Other operations ----------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function Complex(x, y: TComplexType): TComplex; register;
    // Result.x:= x; Result.y:= y
    asm
             FLD x
             FSTP TComplex.x [EAX]
             FLD y
             FSTP TComplex.y [EAX]
    end;
     
    //----------------------------------------------------------------------------//
     
    function cEqual(z1, z2: TComplex): boolean; register;
    // z1 = z2
    asm
             MOV ECX, EAX
             FLD TComplex.x [ECX]
             FLD TComplex.x [EDX]
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             FLD TComplex.y [ECX]
             FLD TComplex.y [EDX]
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             MOV AL, $01
             ret
        @NOT:
             XOR AL, AL
    end;
     
    //----------------------------------------------------------------------------//
     
    function cEqualZero(z: TComplex): boolean; register;
    // z.x = 0 and z.y = 0
    {begin
        Result:= (z.x = 0) and (z.y = 0)
    end;}
    asm
             MOV ECX, EAX
             FLD TComplex.x [ECX]
             FLDZ
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             FLD TComplex.y [ECX]
             FLDZ
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             MOV AL, $1
             RET
        @NOT:
             XOR AL, AL
    end;
     
    //----------------------------------------------------------------------------//
     
    function cEqualOne(z: TComplex): boolean; register;
    // z.x = 1 and z.y = 0
    {begin
        Result:= (z.x = 1) and(z.y = 0)
    end;}
    asm
             MOV ECX, EAX
             FLD TComplex.x [ECX]
             FLD1
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             FLD TComplex.y [ECX]
             FLDZ
             FCOMPP
             FSTSW AX
             SAHF
             JNZ @NOT
             MOV AL, $01
             ret
        @NOT:
             XOR AL, AL
    end;
     
    //----------------------------------------------------------------------------//
    //------ Other operations ----------------------------------------------------//
    //----------------------------------------------------------------------------//
     
    function ComplexToStr(z: TComplex): string;
    var x, y: TComplexType;
    begin
        if not cEqualZero(z) then begin
            Result:= '';
            x:= Re(z);
            y:= Im(z);
            if x <> 0 then Result:= FloatToStr(x);
            if y <> 0 then begin
                if (y > 0) and (x <> 0) then
                    Result:= Result + '+';
                Result:= Result + FloatToStr(y) + 'i'
            end
        end else Result:= '0'
    end;
     
    //----------------------------------------------------------------------------//
     
    function StrToComplex(S: string): TComplex;
    var i: integer;
        sr, si: string;
    begin
        if Length(S) <> 0 then
            if S[Length(S)] in ['i', 'I'] then begin
                i:= Length(S) - 1;
                while (not (S[i] in ['+', '-'])) and (i > 1) do
                    dec(i);
                if S[i - 1] in ['E', 'e'] then begin
                    dec(i);
                    while not (S[i] in ['+', '-']) do
                        dec(i)
                end;
                sr:= Copy(S, 1, i - 1);
                if sr = '' then sr:= '0';
                si:= Copy(S, i, Length(S) - i);
                Result.x:= StrToFloat(sr);
                Result.y:= StrToFloat(si)
            end else begin
                Result.x:= StrToFloat(S);
                Result.y:= 0
            end
        else Result:= NullComplex;
    end;
     
    //----------------------------------------------------------------------------//
     
    function cmPow(z: TComplex; n: integer): TComplex;
    var x, y, r, f: TComplexType;
    begin
        x:= Re(z);
        y:= Im(z);
        r:= Power(SQRT(SQR(x) + SQR(y)), n);
        if x > 0 then f:= ArcTan(y / x)
        else if x < 0 then f:= PI * ArcTan(y / x)
             else if y > 0 then f:= PI / 2
                  else if y < 0 then f:= -PI / 2;
        Result:= Complex(r * COS(n * f), r * SIN(n * f))
    end;
    //----------------------------------------------------------------------------//
    //----------------------------------------------------------------------------//
    //----------------------------------------------------------------------------//
    end. /// end of cmplx module ///
