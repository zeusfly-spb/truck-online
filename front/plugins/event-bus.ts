import mitt from 'mitt';
export default defineNuxtPlugin((nuxtApp) => {
  const { $event } = useNuxtApp();
  const emitter = mitt();
  return {
    provide: {
      event: emitter.emit,
      listen: emitter.on
    }
  }
})
