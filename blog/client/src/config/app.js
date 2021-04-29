import hmacSHA512 from 'crypto-js/hmac-sha512';

const EMAIL = 'andrejnankov@gmail.com';
const HMAC_SECRET_SHARED = "8fa3b5af78224aa0b8b399150bfb3e0386ac02be91fb57373751f2134e5cfa245c009b6501386a521ab077fea3b09a970aa44ce1b64e9183e8bd15070174de19";

export const CONN = {
  url: "http://blog-api.repo", // local
  // url: "https://api.nankov.mk", // prod
  key:
    "a7d80ca415402485d515a831b1c3f0c2bb3afa305e0c76b878c27d3732bda72404a52bbbdb9cc7c73d2b21e606fc4a28caf42e040a2798faff2d165a700ec218",
  data: btoa(EMAIL),
  signature: btoa(hmacSHA512(EMAIL, HMAC_SECRET_SHARED)),
};