import argon2 from 'argon2';

async function asyncCall(){
  const argon2 = require("argon2");

try {
  const hash = await argon2.hash("password");
} catch (err) {
  //...
}
}
