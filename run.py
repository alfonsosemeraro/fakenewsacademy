from backend import *
# import multiprocessing

if __name__ == '__main__':

    # n_cores = multiprocessing.cpu_count()
    app.run(debug=False, threaded = True) # processes = n_cores
