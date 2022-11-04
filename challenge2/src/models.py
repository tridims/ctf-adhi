import email
import string
from dataclasses import dataclass


@dataclass
class User():
    email: str
    password: str
    role: int

    def getRoles(self) -> string:
        return "User" if self.role == 0 else "Admin"
