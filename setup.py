import os

print('Setup...')
print('Processing files...')
os.system('python3 -W ignore assets/home_files.py')
print('Computing network metrics...')
os.system('python3 -W ignore assets/centralities.py')
print('Init database...')
os.system('python3 assets/init_db.py')
print('Setup completed.')
