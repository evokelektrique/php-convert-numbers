<?php

final class Convert {

   public static $ones = ["", "یک",'دو&nbsp;', "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه", "ده", "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نونزده"];
   public static $tens = ["", "", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود"];
   public static $tows = ["", "صد", "دویست", "سیصد", "چهار صد", "پانصد", "ششصد", "هفتصد", "هشت صد", "نه صد"];

   /**
    * Convert english numbers into farsi words.
    * 
    * @param int|integer $number
    * @return string Farsi words
    */
   public static function number_to_farsi(int $number = 0): string {
      if (($number < 0) || ($number > 999999999)) {
         throw new \Exception("Number is out of range");
      }

      // Billions 
      $tn = floor($number / 100000000);
      $number -= $tn * 100000000;

      // Millions 
      $gn = floor($number / 1000000);
      $number -= $gn * 1000000;

      // Thousands 
      $kn = floor($number / 1000);
      $number -= $kn * 1000;

      // Hundreds 
      $hn = floor($number / 100);
      $number -= $hn * 100;

      // Tens 
      $dn = floor($number / 10);
      $n = $number % 10;

      /* Ones */
      $res = "";

      if ($tn) {
         $res .= self::number_to_farsi($tn) .  " میلیارد و ";
      }

      if ($gn) {
         $res .= self::number_to_farsi($gn) .  " میلیون و ";
      }

      if ($kn) {
         $res .= (empty($res) ? "" : " ") .self::number_to_farsi($kn) . " هزار و";
      }

      if ($hn) {
         $res .= (empty($res) ? "" : " ") . self::$tows[$hn] . " و ";
      }

      if ($dn || $n) {
         if (!empty($res)) {
            $res .= "";
         }

         if ($dn < 2) {
            $res .= self::$ones[$dn * 10 + $n];
         } else {
            $res .= self::$tens[$dn];
            
            if ($n) {
               $res .= " و " . self::$ones[$n];
            }
         }
      }

      if (empty($res)) {
         $res = "صفر";
      }

      $res = rtrim($res, " و");

      return $res;
   }
}
