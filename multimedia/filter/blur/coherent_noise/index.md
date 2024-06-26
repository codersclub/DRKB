---
Title: Как добавить когерентный шум?
Author: Ken Perlin
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как добавить когерентный шум?
=============================


    {Coherent noise function over 1, 2 or 3 dimensions by Ken Perlin}
     
    unit perlin;
     
    interface
     
    function noise1(arg: double): double;
    function noise2(vec0, vec1: double): double;
    function noise3(vec0, vec1, vec2: double): double;
    function PNoise1(x, alpha, beta: double; n: integer): double;
    function PNoise2(x, y, alpha, beta: double; n: integer): double;
    function PNoise3(x, y, z, alpha, beta: double; n: integer): double;
     
    {High Alpha: smoother intensity change, lower contrast
    Low Alpha: rapid intensity change, higher contrast
    High Beta: coarse, big spots
    Low Beta: fine, small spots}
     
    implementation
     
    uses
      SysUtils;
     
    const
      defB = $100;
      defBM = $FF;
      defN = $1000;
     
    var
      start: boolean = true;
      p: array[0..defB + defB + 2 - 1] of integer;
      g3: array[0..defB + defB + 2 - 1, 0..2] of double;
      g2: array[0..defB + defB + 2 - 1, 0..1] of double;
      g1: array[0..defB + defB + 2 - 1] of double;
     
    function s_curve(t: double): double;
    begin
      result := t * t * (3.0 - 2.0 * t);
    end;
     
    function lerp(t, a, b: double): double;
    begin
      result := a + t * (b - a);
    end;
     
    procedure setup(veci: double; var b0, b1: integer; var r0, r1: double);
    var
      t: double;
    begin
      t := veci + defN;
      b0 := trunc(t) and defBM;
      b1 := (b0 + 1) and defBM;
      r0 := t - int(t);
      r1 := r0 - 1.0;
    end;
     
    procedure normalize2(var v0, v1: double);
    var
      s: double;
    begin
      s := sqrt(v0 * v0 + v1 * v1);
      v0 := v0 / s;
      v1 := v1 / s;
    end;
     
    procedure normalize3(var v0, v1, v2: double);
    var
      s: double;
    begin
      s := sqrt(v0 * v0 + v1 * v1 + v2 * v2);
      v0 := v0 / s;
      v1 := v1 / s;
      v2 := v2 / s;
    end;
     
    procedure init;
    var
      i, j, k: integer;
    begin
      for i := 0 to defB - 1 do
      begin
        p[i] := i;
        g1[i] := (random(defB + defB) - defB) / defB;
        for j := 0 to 1 do
          g2[i, j] := (random(defB + defB) - defB) / defB;
        normalize2(g2[i, 0], g2[i, 1]);
        for j := 0 to 2 do
          g3[i, j] := (random(defB + defB) - defB) / defB;
        normalize3(g3[i, 0], g3[i, 1], g3[i, 2]);
      end;
      i := defB;
      while i > 0 do
      begin
        k := p[i];
        j := random(defB);
        p[i] := p[j];
        p[j] := k;
        dec(i);
      end;
      for i := 0 to defB + 1 do
      begin
        p[defB + i] := p[i];
        g1[defB + i] := g1[i];
        for j := 0 to 1 do
          g2[defB + i, j] := g2[i, j];
        for j := 0 to 2 do
          g3[defB + i, j] := g3[i, j];
      end;
    end;
     
    function noise1(arg: double): double;
    var
      bx0, bx1: integer;
      rx0, rx1, sx, u, v: double;
    begin
      if start then
      begin
        init;
        start := false;
      end;
      bx0 := trunc(arg + defN) and defBM;
      bx1 := (bx0 + 1) and defBM;
      rx0 := frac(arg + defN);
      rx1 := rx0 - 1.0;
      sx := rx0 * rx0 * (3.0 - 2.0 * rx0);
      u := rx0 * g1[p[bx0]];
      v := rx1 * g1[p[bx1]];
      result := u + sx * (v - u);
    end;
     
    function noise2(vec0, vec1: double): double;
    var
      i, j, bx0, bx1, by0, by1, b00, b10, b01, b11: integer;
      rx0, rx1, ry0, ry1, sx, sy, a, b, u, v: double;
    begin
      if start then
      begin
        init;
        start := false;
      end;
      bx0 := trunc(vec0 + defN) and defBM;
      bx1 := (bx0 + 1) and defBM;
      rx0 := frac(vec0 + defN);
      rx1 := rx0 - 1.0;
      by0 := trunc(vec1 + defN) and defBM;
      by1 := (by0 + 1) and defBM;
      ry0 := frac(vec1 + defN);
      ry1 := ry0 - 1.0;
      i := p[bx0];
      j := p[bx1];
      b00 := p[i + by0];
      b10 := p[j + by0];
      b01 := p[i + by1];
      b11 := p[j + by1];
      sx := rx0 * rx0 * (3.0 - 2.0 * rx0);
      sy := ry0 * ry0 * (3.0 - 2.0 * ry0);
      u := rx0 * g2[b00, 0] + ry0 * g2[b00, 1];
      v := rx1 * g2[b10, 0] + ry0 * g2[b10, 1];
      a := u + sx * (v - u);
      u := rx0 * g2[b01, 0] + ry1 * g2[b01, 1];
      v := rx1 * g2[b11, 0] + ry1 * g2[b11, 1];
      b := u + sx * (v - u);
      result := a + sy * (b - a);
    end;
     
    function noise3orig(vec0, vec1, vec2: double): double;
    var
      i, j, bx0, bx1, by0, by1, bz0, bz1, b00, b10, b01, b11: integer;
      rx0, rx1, ry0, ry1, rz0, rz1, sx, sy, sz, a, b, c, d, u, v: double;
    begin
      if start then
      begin
        start := false;
        init;
      end;
      setup(vec0, bx0, bx1, rx0, rx1);
      setup(vec1, by0, by1, ry0, ry1);
      setup(vec2, bz0, bz1, rz0, rz1);
      i := p[bx0];
      j := p[bx1];
      b00 := p[i + by0];
      b10 := p[j + by0];
      b01 := p[i + by1];
      b11 := p[j + by1];
      sx := s_curve(rx0);
      sy := s_curve(ry0);
      sz := s_curve(rz0);
      u := rx0 * g3[b00 + bz0, 0] + ry0 * g3[b00 + bz0, 1] + rz0 * g3[b00 + bz0, 2];
      v := rx1 * g3[b10 + bz0, 0] + ry0 * g3[b10 + bz0, 1] + rz0 * g3[b10 + bz0, 2];
      a := lerp(sx, u, v);
      u := rx0 * g3[b01 + bz0, 0] + ry1 * g3[b01 + bz0, 1] + rz0 * g3[b01 + bz0, 2];
      v := rx1 * g3[b11 + bz0, 0] + ry1 * g3[b11 + bz0, 1] + rz0 * g3[b11 + bz0, 2];
      b := lerp(sx, u, v);
      c := lerp(sy, a, b);
      u := rx0 * g3[b00 + bz1, 0] + ry0 * g3[b00 + bz1, 1] + rz1 * g3[b00 + bz1, 2];
      v := rx1 * g3[b10 + bz1, 0] + ry0 * g3[b10 + bz1, 1] + rz1 * g3[b10 + bz1, 2];
      a := lerp(sx, u, v);
      u := rx0 * g3[b01 + bz1, 0] + ry1 * g3[b01 + bz1, 1] + rz1 * g3[b01 + bz1, 2];
      v := rx1 * g3[b11 + bz1, 0] + ry1 * g3[b11 + bz1, 1] + rz1 * g3[b11 + bz1, 2];
      b := lerp(sx, u, v);
      d := lerp(sy, a, b);
      result := lerp(sz, c, d);
    end;
     
    function noise3(vec0, vec1, vec2: double): double;
    var
      i, j, bx0, bx1, by0, by1, bz0, bz1, b00, b10, b01, b11: integer;
      rx0, rx1, ry0, ry1, rz0, rz1, sx, sy, sz, a, b, c, d, u, v: double;
    begin
      if start then
      begin
        start := false;
        init;
      end;
      bx0 := trunc(vec0 + defN) and defBM;
      bx1 := (bx0 + 1) and defBM;
      rx0 := frac(vec0 + defN);
      rx1 := rx0 - 1.0;
      by0 := trunc(vec1 + defN) and defBM;
      by1 := (by0 + 1) and defBM;
      ry0 := frac(vec1 + defN);
      ry1 := ry0 - 1.0;
      bz0 := trunc(vec2 + defN) and defBM;
      bz1 := (bz0 + 1) and defBM;
      rz0 := frac(vec2 + defN);
      rz1 := rz0 - 1.0;
      i := p[bx0];
      j := p[bx1];
      b00 := p[i + by0];
      b10 := p[j + by0];
      b01 := p[i + by1];
      b11 := p[j + by1];
      sx := rx0 * rx0 * (3.0 - 2.0 * rx0);
      sy := ry0 * ry0 * (3.0 - 2.0 * ry0);
      sz := rz0 * rz0 * (3.0 - 2.0 * rz0);
      u := rx0 * g3[b00 + bz0, 0] + ry0 * g3[b00 + bz0, 1] + rz0 * g3[b00 + bz0, 2];
      v := rx1 * g3[b10 + bz0, 0] + ry0 * g3[b10 + bz0, 1] + rz0 * g3[b10 + bz0, 2];
      a := u + sx * (v - u);
      u := rx0 * g3[b01 + bz0, 0] + ry1 * g3[b01 + bz0, 1] + rz0 * g3[b01 + bz0, 2];
      v := rx1 * g3[b11 + bz0, 0] + ry1 * g3[b11 + bz0, 1] + rz0 * g3[b11 + bz0, 2];
      b := u + sx * (v - u);
      c := a + sy * (b - a);
      u := rx0 * g3[b00 + bz1, 0] + ry0 * g3[b00 + bz1, 1] + rz1 * g3[b00 + bz1, 2];
      v := rx1 * g3[b10 + bz1, 0] + ry0 * g3[b10 + bz1, 1] + rz1 * g3[b10 + bz1, 2];
      a := u + sx * (v - u);
      u := rx0 * g3[b01 + bz1, 0] + ry1 * g3[b01 + bz1, 1] + rz1 * g3[b01 + bz1, 2];
      v := rx1 * g3[b11 + bz1, 0] + ry1 * g3[b11 + bz1, 1] + rz1 * g3[b11 + bz1, 2];
      b := u + sx * (v - u);
      d := a + sy * (b - a);
      result := c + sz * (d - c);
    end;
     
    {Harmonic summing functions}
     
    {In what follows "alpha" is the weight when the sum is formed. Typically it is 2. As this
    approaches 1 the function is noisier.
    "beta" is the harmonic scaling/spacing, typically 2.
    persistance = 1/alpha
    beta = frequency
    N = octaves}
     
    function PNoise1(x, alpha, beta: double; n: integer): double;
    var
      i: integer;
      val, sum, p, scale: double;
    begin
      sum := 0;
      scale := 1;
      p := x;
      for i := 0 to n - 1 do
      begin
        val := noise1(p);
        sum := sum + val / scale;
        scale := scale * alpha;
        p := p * beta;
      end;
      result := sum;
    end;
     
    function PNoise2(x, y, alpha, beta: double; n: integer): double;
    var
      i: integer;
      val, sum, px, py, scale: double;
    begin
      sum := 0;
      scale := 1;
      px := x;
      py := y;
      for i := 0 to n - 1 do
      begin
        val := noise2(px, py);
        sum := sum + val / scale;
        scale := scale * alpha;
        px := px * beta;
        py := py * beta;
      end;
      result := sum;
    end;
     
    function PNoise3(x, y, z, alpha, beta: double; n: integer): double;
    var
      i: integer;
      val, sum, px, py, pz, scale: double;
    begin
      sum := 0;
      scale := 1;
      px := x;
      py := y;
      pz := z;
      for i := 0 to n - 1 do
      begin
        val := noise3(px, py, pz);
        sum := sum + val / scale;
        scale := scale * alpha;
        px := px * beta;
        py := py * beta;
        pz := pz * beta;
      end;
      result := sum;
    end;
     
    end.

Used like this:

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Image1: TImage;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    uses
      perlin;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      x, y, z, c: integer;
    begin
      image1.Canvas.Brush.Color := 0;
      image1.Canvas.FillRect(image1.Canvas.ClipRect);
      for x := 0 to 511 do
        for y := 0 to 511 do
        begin
          z := trunc(pnoise2(x / 100, y / 100, 2, 2, 10) * 128) + 128;
          c := z + (z shl 8) + (z shl 16);
          image1.Canvas.Pixels[x, y] := c;
        end;
      c := 0;
      repeat
        image1.Canvas.Pixels[519, c] := $FFFFFF;
        c := c + 10;
      until
        c > 510;
    end;
     
    end.

