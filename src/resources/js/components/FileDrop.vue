<template>
    <div>
        <div v-if="!started" :class="classes" @dragover="dragover" @dragleave="dragleave" @drop="drop">
            <input type="file" name="fileHandler" id="fileHandler" class="absolute w-px h-px overflow-hidden opacity-0" ref="file" @change="onChange" accept=".mp4, .mov, .m4a" />
            <label v-if="!video" for="fileHandler" class="block cursor-pointer">
                <p class="text-lg text-center text-gray-500">Drag + drop a file here or <span class="underline hover:text-gray-800">click to choose</span>.</p>
            </label>
            <div v-else>
                <p class="text-lg text-center text-gray-500">You chose <span class="font-bold">{{ video.name }}</span>. Select your options then press start.</p>
                <button :class="buttonStyles.active">Subtitles</button>
                <button :class="options.chapters ? buttonStyles.active : buttonStyles.inactive" @click="options.chapters = !options.chapters">Chapters</button>
                <button :class="options.summary ? buttonStyles.active : buttonStyles.inactive" @click="options.summary = !options.summary">Summary</button>
                <div>
                    <select v-model="options.language" class="px-4 py-2 mx-2 mt-4 font-medium text-gray-500 bg-white border border-gray-300 rounded">
                        <option value="default">Video Language</option>
                        <option v-for="language in languages" :value="language" :key="language">{{ language }}</option>
                    </select>
                    <select v-if="options.chapters" v-model="options.chapters_amount" class="px-4 py-2 mx-2 mt-4 font-medium text-gray-500 bg-white border border-gray-300 rounded">
                        <option :value="n" v-for="n in 20">{{ n }} Chapter{{ n !== 1 ? 's' : '' }}</option>
                    </select>
                    <button class="mt-4 bg-purple-500 border border-purple-500 text-white font-medium py-1.5 px-4 rounded mx-2" @click="start">Start</button>
                </div>
            </div>
        </div>
        <div v-else>
            <Stepper :step="step" :message="message" />
        </div>
        <div v-if="started && step === 98" class="mt-8 text-center">
            <a :href="'/process/' + processId" class="inline-block px-4 py-2 font-semibold text-white bg-purple-500 rounded hover:bg-purple-600">
                View + Download Items
            </a>
        </div>
        <div v-if="processId.length > 0" class="fixed bottom-0 left-0 w-full py-2.5 bg-purple-600 text-white text-center">
            <p class="font-bold">Your process ID is {{ processId.value }}, please copy this number and use it to retrieve the result later!</p>
        </div>
    </div>
</template>
<script setup>
import { ref, reactive } from 'vue'
import Stepper from './Stepper.vue'
import axios from 'axios'

const file = ref(null)
const video = ref(null)
const classes = ref('flex justify-center items-center w-full h-64 border-2 border-dashed mt-12')

const started = ref(false)
const processId = ref(null)
const intervalId = ref(null)

const step = ref(1)
const message = ref('Extracting audio')

const languages = ref([
    'English',
    'Spanish',
    'French',
    'German',
    'Italian',
    'Portuguese',
    'Russian',
    'Chinese',
    'Japanese',
    'Korean',
])

const options = reactive({
    subtitles: true,
    chapters: false,
    summary: false,
    language: 'default',
    chapters_amount: 5
})

const buttonStyles = reactive({
    'inactive': 'mt-4 bg-white border border-purple-500 text-purple-500 font-medium py-1.5 px-4 rounded mx-2',
    'active': 'mt-4 bg-purple-500 border border-purple-500 text-white font-medium py-1.5 px-4 rounded mx-2'
})

const onChange = () => {
    video.value = file.value.files[0]
}

const dragover = (e) => {
    e.preventDefault()
    e.stopPropagation()
    classes.value = 'flex justify-center items-center w-full h-64 border-2 border-dashed mt-12 border-purple-500 bg-gradient-to-br from-indigo-50 to-rose-50'
}

const dragleave = (e) => {
    e.preventDefault()
    e.stopPropagation()
    classes.value = 'flex justify-center items-center w-full h-64 border-2 border-dashed mt-12'
}

const drop = (e) => {
    e.preventDefault()
    e.stopPropagation()
    classes.value = 'w-full py-24 border-2 border-dashed mt-12'
    video.value = e.dataTransfer.files[0]
}

const start = () => {
    started.value = true
    axios.post('/api/process', {
        video: video.value,
        options: options
    }, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then((response) => {
        processId.value = response.data.id
        intervalId.value = setInterval(poll, 3000)
        console.log(response)
    }).catch((error) => {
        console.log(error)
    })
}

const poll = () => {
    axios.get('/api/process/' + processId.value)
        .then((response) => {
            step.value = response.data.status
            message.value = response.data.message

            if (response.data.status === 98) {
                clearInterval(intervalId.value)
            }

            if (response.data.status === 99) {
                console.log(response)
                clearInterval(intervalId.value)
            }

            console.log(response)
        })
        .catch((error) => {
            clearInterval(intervalId.value)
            console.log(error)
        })
}
</script>