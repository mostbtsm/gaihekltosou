<template>
  <div>
    <Slider :images="images"/>
  </div>
</template>

<script>
import { Api } from "js/route/painter.js";
import Slider from "js/components/Slider.vue";

export default {
  data() {
    return {
      images:[],
      image_files: {
        image_file1: {
          img: true,
          src: '',
        },
        image_file2: {
          img: true,
          src: '',
        },
        image_file3: {
          img: true,
          src: '',
        },
        image_file4: {
          img: true,
          src: '',
        },
        image_file5: {
          img: true,
          src: '',
        },
        image_file6: {
          img: true,
          src: '',
        },
      },
    };
  },
  mounted() {
    this.getImages();
  },
  methods: {
    async getImages() {
      await axios.get(Api.images).then(response => {

        var i = 0;
        var j = 0;
        for (var k in response.data) {
           i += 1;
           j = 0;
           Object.keys(this.image_files).forEach(key => {
             j += 1;
             if (i == j) {
                 this.$set(this.image_files[key], 'src', response.data[k].image_file);
             }
           });
        }
      }).catch(error => {
        if (error.response) {
          if (error.response.status == 422) {
          }
        }
      });

      this.getImageURL();

    },
    getImageURL() {

      Object.keys(this.image_files).forEach(key => {
        if (this.image_files[key].src != ''){
          let params = new URLSearchParams();
          params.append("image_file", this.image_files[key].src);
          axios.get(Api.imageurl, {params: params }).then(response => {
            this.$set(this.image_files[key], 'src', response.data.image_file);

            this.images.push(this.image_files[key]);

          }).catch(error => {
            if (error.response) {
              if (error.response.status == 422) {
              }
            }
          });
        }
      });

    },
  },
  components: {
    Slider,
  },
};
</script>