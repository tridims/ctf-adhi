import pickle
import base64

data = 'gASVdQAAAAAAAACMCnNyYy5tb2RlbHOUjARVc2VylJOUKYGUfZQojAVlbWFpbJSMCm1hcmt1cHNhZmWUjAZNYXJrdXCUk5SMDnRlc3RAZ21haWwuY29tlIWUgZSMCHBhc3N3b3JklGgIjAR0ZXN0lIWUgZSMBHJvbGWUSwB1Yi4='

res = pickle.loads(base64.urlsafe_b64decode(data))
print(res)
