package com.example.taskapp.ui.read

import androidx.lifecycle.*
import com.example.taskapp.data.data.Task
import com.example.taskapp.data.repository.MyRepository
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import java.util.*

class ReadViewModel (private val repository: MyRepository) : ViewModel() {

    private var task: Task = Task()

    fun getTask() : Task {
        return task
    }

    fun setTask(task: Task) {
        this.task = task
        mutableName.value = task.name
        mutableStatus.value = task.status
        mutableStarred.value = task.starred
        mutableEstimate.value = task.estimate
        mutableDue.value = task.due
        mutablePlan.value = task.plan
        mutableRemind.value = task.remind
        mutableDescription.value = task.description
    }

    private fun update(task: Task) {

        viewModelScope.launch(Dispatchers.IO) {
            task.modifiedTime = Calendar.getInstance().time
            repository.update(task)
        }
    }

    fun deleteTask() {

        viewModelScope.launch(Dispatchers.IO) {
            repository.delete(task)
        }
    }

    private val mutableName = MutableLiveData(task.name)
    val name: LiveData<String> get() = mutableName
    fun setName(name: String) {
        task.name = name
        mutableName.value = task.name
        update(task)
    }

    private val mutableStatus = MutableLiveData(task.status)
    val status: LiveData<Int> get() = mutableStatus
    fun setStatus(status: Int) {
        task.status = status
        mutableStatus.value = task.status
        task.checkedTime = if(task.status == 1) Calendar.getInstance().time else null
        update(task)
    }
    fun getStatus() : Int {
        return task.status
    }

    private val mutableStarred = MutableLiveData(task.starred)
    val starred: LiveData<Boolean> get() = mutableStarred
    fun setStarred(starred: Boolean) {
        task.starred = starred
        mutableStarred.value = task.starred
        update(task)
    }
    fun switchStarred() {
        task.starred = !task.starred
        mutableStarred.value = task.starred
        update(task)
    }

    private val mutableDue = MutableLiveData(task.due)
    val due: LiveData<Date?> get() = mutableDue
    fun setDue(due: Date?) {
        task.due = due
        mutableDue.value = task.due
        update(task)
    }

    private val mutableEstimate = MutableLiveData(task.estimate)
    val estimate: LiveData<Int?> get() = mutableEstimate
    fun getEstimate() : Int? {
        return mutableEstimate.value
    }
    fun setEstimate(estimate: Int?) {
        task.estimate = estimate
        mutableEstimate.value = task.estimate
        update(task)
    }

    private val mutablePlan = MutableLiveData(task.plan)
    val plan: LiveData<Date?> get() = mutablePlan
    fun setPlan(plan: Date?) {
        task.plan = plan
        mutablePlan.value = task.plan
        update(task)
    }

    private val mutableRemind = MutableLiveData(task.remind)
    val remind: LiveData<Date?> get() = mutableRemind
    fun setRemind(remind: Date?) {
        task.remind = remind
        mutableRemind.value = task.remind
        update(task)
    }

    private val mutableDescription = MutableLiveData(task.description)
    val description: LiveData<String?> get() = mutableDescription
    fun setDescription(description: String?) {
        task.description = description
        mutableDescription.value = task.description
        update(task)
    }
}

class ReadViewModelFactory(private val repository: MyRepository) : ViewModelProvider.Factory {
    override fun <T : ViewModel> create(modelClass: Class<T>): T {
        if (modelClass.isAssignableFrom(ReadViewModel::class.java)) {
            @Suppress("UNCHECKED_CAST")
            return ReadViewModel(repository) as T
        }
        throw IllegalArgumentException("Unknown ViewModel class")
    }
}